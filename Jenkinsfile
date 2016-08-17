// This build is parameterized :
// - PROJECT_PATH : string parameter
node {
    
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
            sh 'vendor/bin/parallel-lint src/'
        }
}