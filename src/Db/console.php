<?php

namespace ExampleCode\Db;

$loader = require __DIR__.'/../../vendor/autoload.php';

use PDO;

$sqlite = new PDO( 'sqlite::memory:');
$sqlite->exec('
    CREATE TABLE users (
        login VARCHAR,
        password VARCHAR
    );
');


$csvDataProviderGenerator = new CsvDataProviderGenerator;
if (!$csvDataProviderGenerator->open(__DIR__ . '/users.csv')) {
    return;
}

$restore = new Restore;
$restore->setPdoConnection($sqlite);
$restore->setDataProviderGenerator($csvDataProviderGenerator);

$restore->restore();
print_r($restore->fetchRestored());