// This build is parameterized :
// - PROJECT_PATH : string parameter
// - INTERNET : choice parameter true/false
//Jenkins plugins :
// - Static Analysis Utilities + checkstyle plugin
// - pmd plugin
// - Robot Framework plugin
node {

    stage("Clean") {
        sh 'rm -rf build/'
        sh 'mkdir build/'
        sh 'mkdir build/logs/'
    }
    
    stage("InitDB") { 
        dir("${PROJECT_PATH}") {
            sh 'php bin/console doctrine:database:drop --force --no-interaction'
            sh 'php bin/console doctrine:database:create --no-interaction'
            sh 'php bin/console doctrine:schema:create --no-interaction'
            sh 'php bin/console doctrine:fixtures:load --no-interaction'
        }
    }

    stage("Update") {
        composerUpdate()
    }
        
    stage("Check") {
        dir("${PROJECT_PATH}") {
            sh 'vendor/bin/php-cs-fixer fix --config=sf23 --fixers=-declare_equal_normalize . || true'
            sh 'vendor/bin/parallel-lint src/'
        }
        runPhpcs()
        runPhpmd()
    }
    
    stage("Unit Tests") {
        runUnitTests()
    }
    
    stage("RF Tests") {
        runRFTests()
    }
}

def composerUpdate() {
    boolean internet = INTERNET.toBoolean()
    if (internet) {
        dir("${PROJECT_PATH}") {
            sh 'php bin/composer self-update'
            sh 'php bin/composer update'
        }
    } else {
        echo "No Internet !"
    }
}

def runPhpcs() {
    def workspace = pwd()
    try {
        dir("${PROJECT_PATH}") {
            sh "vendor/bin/phpcs -v --ignore=src/AppBundle/Tests/* --report=checkstyle --report-file=${workspace}/build/logs/checkstyle.xml --standard=Standards/ruleset-cs.xml --extensions=php src/"
        }
    } catch (err) {
        currentBuild.result = 'FAILURE'
    }
    finally {
        step([$class: 'CheckStylePublisher', pattern: "build/logs/checkstyle.xml"])
    }
}

def runPhpmd() {
    def workspace = pwd()
    try {
        dir("${PROJECT_PATH}") {
            sh "vendor/bin/phpmd src/ xml Standards/ruleset-pmd.xml --reportfile ${workspace}/build/logs/pmd.xml --exclude DataFixtures,Tests"
        }
    } catch (err) {
        currentBuild.result = 'FAILURE'
    }
    finally {
        step([$class: 'PmdPublisher', pattern: "build/logs/pmd.xml"])
    }
}
def runUnitTests() {
    def workspace = pwd()
    try {
        dir("${PROJECT_PATH}") {
            sh "vendor/bin/phpunit --log-junit ${workspace}/build/logs/phpunit-junit.xml"
        }
    }
    catch (err) {
        junit 'build/logs/phpunit-junit.xml'
        throw err
    }    
}

def runRFTests() {
    def workspace = pwd()
    try {
        dir("${PROJECT_PATH}") {
            sh "robot -d ${workspace}/build/logs --xunit rf-junit.xml -v CONSOLE_PATH:bin/console -v REMOTE:True -v HUB:http://localhost:4444/wd/hub -v BROWSER:gc src/AppBundle/Tests/RFTests"
        }
    }
    finally {
        junit 'build/logs/*-junit.xml'
        step([$class: 'RobotPublisher', disableArchiveOutput: false, logFileName: 'log.html', onlyCritical: true, otherFiles: '*.png', outputFileName: 'output.xml', outputPath: 'build/logs/', passThreshold: 90, reportFileName: 'report.html', unstableThreshold: 100])
    }
}
