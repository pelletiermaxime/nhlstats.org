<?php

return [

    // Tasks
    //
    // Here you can define in the `before` and `after` array, Tasks to execute
    // before or after the core Rocketeer Tasks. You can either put a simple command,
    // a closure which receives a $task object, or the name of a class extending
    // the Rocketeer\Abstracts\AbstractTask class
    //
    // In the `custom` array you can list custom Tasks classes to be added
    // to Rocketeer. Those will then be available in the command line
    // with all the other tasks
    //////////////////////////////////////////////////////////////////////

    // Tasks to execute before the core Rocketeer Tasks
    'before' => [
        'setup'   => [],
        'deploy'  => [],
        'cleanup' => [],
    ],

    // Tasks to execute after the core Rocketeer Tasks
    'before-symlink'  => [
        'deploy'  => [
            'npm install',
            'gulp --production',
            'sudo service php-fpm reload',
            'php artisan api:docs > public/doc/APIDoc.md',
            'node_modules/.bin/aglio --theme-variables slate -i public/doc/APIDoc.md -o public/doc/index.html',
        ],
    ],

    // Custom Tasks to register with Rocketeer
    'custom' => [],

];
