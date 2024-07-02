<?php

declare(strict_types=1);

require_once __DIR__.'/../common/database.php';

if (PHP_SAPI !== 'cli') {
    echo 'Can be run only via console.';
    exit(1);
}

$connection = database_connect();
$connection->query('CREATE TABLE IF NOT EXISTS migrations(version SMALLINT)');

$executedMigrations = array_column(
    $connection->query('SELECT * FROM migrations')->fetchAll(PDO::FETCH_ASSOC),
    'version'
);
sort($executedMigrations, SORT_NUMERIC);

$migrationsDirectory = opendir('migrations');
if ($migrationsDirectory === false) {
    echo 'Cannot open "migrations" directory.';
    exit(1);
}
$currentMigrations = [];
while (false !== ($entry = readdir($migrationsDirectory))) {
    if ($entry === '.' || $entry === '..') {
        continue;
    }

    [$version, $extension] = explode('.', $entry);

    if (is_numeric($version) === false || $extension !== 'php') {
        echo 'Wrong file "'.$entry.'" inside "migrations" directory.';
        exit(1);
    }

    $currentMigrations[] = $version;
}


$toExecute = array_diff($currentMigrations, $executedMigrations);
sort($toExecute, SORT_NUMERIC);

foreach ($toExecute as $version) {
    require_once __DIR__.'/../migrations/'.$version.'.php';

    $connection->query('INSERT INTO migrations VALUES('.$version.')');
}

echo 'Executed migrations: '.count($toExecute)."\n";
