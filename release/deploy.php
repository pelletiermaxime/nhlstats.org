<?php
require 'recipe/laravel.php';
require 'database-sync.php';

/// Server config
server('production', 'nhlstats.org', 36220)
    ->user('max')
    ->forwardAgent()
    ->stage('prod')
    ->env('deploy_path', '/var/www/nhlstats.org');

localServer('local')
    ->stage('prod');

set('repository', 'https://github.com/pelletiermaxime/nhlstats.org');

set('writable_use_sudo', false);

set('shared_dirs', [
    'node_modules'
]);

/// Custom tasks
task('nhlstats:gulp', function () {
    cd('{{release_path}}');
    run('npm install');
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

/// Hooks
before('deploy:symlink', 'nhlstats:generate-doc');
before('nhlstats:generate-doc', 'nhlstats:gulp');

after('deploy', 'reload:php-fpm');

// Overwrite laravel recipe because route and config cache don't work for this project
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');
