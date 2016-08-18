// This build is parameterized :
// - PROJECT_PATH : string parameter
node {
    def workspace = pwd()
    
    stage 'Clean'
        sh 'rm -rf build/'
        sh 'mkdir build/'
        sh 'mkdir build/logs/'
        
    stage 'InitDB'
        dir("${PROJECT_PATH}") {
            sh 'php bin/console doctrine:database:drop --force'
            sh 'php bin/console doctrine:database:create'
            sh 'php bin/console doctrine:schema:update --force'
            sh 'php bin/console doctrine:fixtures:load  -n'
        }

    stage 'Update'
        dir("${PROJECT_PATH}") {
            sh 'php bin/composer self-update'
            sh 'php bin/composer update'
        }
        
    stage 'Check'
        dir("${PROJECT_PATH}") {
            sh 'vendor/bin/php-cs-fixer fix --config=sf23 .'
            sh 'vendor/bin/parallel-lint src/'
            sh "vendor/bin/phpcs -v --report=checkstyle --report-file=${workspace}/build/logs/checkstyle.xml --standard=Standards/ruleset-cs.xml --extensions=php src/ || true"
        }
        archiveCheckstyleResults()
}

def archiveCheckstyleResults() {
    step([$class: 'CheckStylePublisher',
        pattern: "build/logs/checkstyle.xml"
    ])
}