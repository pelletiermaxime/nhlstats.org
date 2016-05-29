<?php

env('localPath', 'database.sql.gz');
env('remotePath', '/tmp/database.sql.gz');
env('localDatabaseName', 'nhlstats');

function configFromEnvFile($config)
{
    $envFilePath = env('deploy_path') . "/current/.env";
    $valueLine = run("cat $envFilePath | grep $config");

    if (strpos($valueLine, '=') !== false) {
        $value = array_map('trim', explode('=', $valueLine, 2))[1];
    }
    return $value;
}

function databaseDumpCommand()
{
    $remotePath    = env('remotePath');

    $databaseName = configFromEnvFile('DB_DATABASE');
    $databaseUsername = configFromEnvFile('DB_USERNAME');
    $databasePassword = configFromEnvFile('DB_PASSWORD');

    return "mysqldump -u$databaseUsername -p$databasePassword $databaseName | gzip > $remotePath";
}

function databaseRestoreCommand()
{
    $localDatabaseName = env('localDatabaseName');
    $localPath     = env('localPath');

    return "zcat $localPath | mysql $localDatabaseName";
}

task('database:dump', function () {
    $localPath  = env('localPath');
    $remotePath = env('remotePath');

    run(databaseDumpCommand());
    download($localPath, $remotePath);
    run("rm $remotePath");
})->onlyOn('prod');

task('database:restore', function () {
    $localPath = env('localPath');

    runLocally(databaseRestoreCommand());
    runLocally("rm $localPath");
})->onlyOn('local');

task('database:sync', [
     'database:dump',
     'database:restore',
]);
