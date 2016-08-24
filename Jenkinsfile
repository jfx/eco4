// This build is parameterized :
// - PROJECT_PATH : string parameter
//Jenkins plugins :
// - Static Analysis Utilities + checkstyle plugin
// - pmd plugin
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
            sh 'vendor/bin/php-cs-fixer fix --config=sf23 --fixers=-declare_equal_normalize . || true'
            sh 'vendor/bin/parallel-lint src/'
            sh "vendor/bin/phpcs -v --ignore=src/AppBundle/Tests/* --report=checkstyle --report-file=${workspace}/build/logs/checkstyle.xml --standard=Standards/ruleset-cs.xml --extensions=php src/"
            sh "vendor/bin/phpmd src/ xml Standards/ruleset-pmd.xml --reportfile ${workspace}/build/logs/pmd.xml --exclude DataFixtures,Tests || true"
        }
        step([$class: 'CheckStylePublisher', pattern: 'build/logs/checkstyle.xml'])
        step([$class: 'PmdPublisher', pattern: 'build/logs/pmd.xml'])

    stage 'Test'
        dir("${PROJECT_PATH}") {
            sh "vendor/bin/phpunit --log-junit ${workspace}/build/logs/phpunit-junit.xml"
        }
        junit 'build/logs/phpunit-junit.xml'

}