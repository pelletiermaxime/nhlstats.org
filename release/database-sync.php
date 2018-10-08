<?php

namespace Deployer;

set('localPath', 'database.sql.gz');
set('remotePath', '/tmp/database.sql.gz');
set('localDatabaseName', 'nhlstats');
set('envFilePath', function () {
    return get('deploy_path') . "/current/.env";
});

function configFromEnvFile($config)
{
    $envFilePath = get('envFilePath');
    $valueLine   = run("cat $envFilePath | grep $config");

    if (strpos($valueLine, '=') !== false) {
        $value = array_map('trim', explode('=', $valueLine, 2))[1];
    }

    return $value;
}

function databaseDumpCommand()
{
    $remotePath       = get('remotePath');
    $databaseName     = configFromEnvFile('DB_DATABASE');
    $databaseUsername = configFromEnvFile('DB_USERNAME');
    $databasePassword = configFromEnvFile('DB_PASSWORD');

    return "mysqldump -u$databaseUsername -p$databasePassword $databaseName | gzip > $remotePath";
}

function databaseRestoreCommand()
{
    $localDatabaseName = get('localDatabaseName');
    $localPath         = get('localPath');

    return "zcat $localPath | mysql $localDatabaseName";
}

task('database:dump', function () {
    $localPath  = get('localPath');
    $remotePath = get('remotePath');

    run(databaseDumpCommand());
    download($localPath, $remotePath);
    run("rm $remotePath");
})->onlyOn('production');

task('database:restore', function () {
    $localPath = get('localPath');

    runLocally(databaseRestoreCommand());
    runLocally("rm $localPath");
})->onlyOn('local');

task('database:sync', [
     'database:dump',
     'database:restore',
]);
