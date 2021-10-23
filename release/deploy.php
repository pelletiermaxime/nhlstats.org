<?php
namespace Deployer;

require 'recipe/laravel.php';
 require 'database-sync.php';

/// Configuration
//set('ssh_type', 'native');
//set('ssh_multiplexing', true);

/// Server config
server('production', 'nhlstats.org', 36220)
    ->user('max')
->password()
//    ->identityFile()
    ->stage('prod')
    ->set('deploy_path', '/var/www/nhlstats.org')
    ->pty(true)
;

// localServer('local')
    // ->stage('prod');

set('repository', 'https://github.com/pelletiermaxime/nhlstats.org');

set('writable_use_sudo', false);

set('shared_dirs', [
    'node_modules'
]);

/// Custom tasks
task('nhlstats:gulp', function () {
    cd('{{release_path}}');
    run('npm ci');
    run('gulp --production');
});

task('nhlstats:generate-doc', function () {
    cd('{{release_path}}');
    run('php artisan api:docs > public/doc/APIDoc.md');
    $theme  = '--theme-full-width --theme-variables slate';
    $input  = '-i public/doc/APIDoc.md';
    $output = '-o public/doc/index.html';
    run("node_modules/.bin/aglio $theme $input $output");
});

task('reload:php-fpm', function () {
    run('sudo service php-fpm reload');
});

// Overwrite laravel recipe because route and config cache don't work for this project
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'nhlstats:gulp',
    // 'nhlstats:generate-doc',
    'deploy:symlink',
    'cleanup',
    // 'reload:php-fpm',
])->desc('Deploy your project');
