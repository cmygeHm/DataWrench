<?php

namespace ExampleCode\Db;

require __DIR__ . '/../vendor/autoload.php';

use ExampleCode\DataImport\Reader\CsvReader;
use ExampleCode\DataImport\Writer\SqlWriter;
use PDO;

$sqlite = new PDO('sqlite::memory:');
$sqlite->exec('
    CREATE TABLE users (
        login VARCHAR,
        password VARCHAR
    );
');

$csvDataProviderGenerator = new CsvReader;
if (!$csvDataProviderGenerator->open(__DIR__ . '/users.csv')) {
    return;
}

$restore = new SqlWriter;
$restore->setPdoConnection($sqlite);
$restore->setDataProviderGenerator($csvDataProviderGenerator);

$restore->restore();

print_r(
    $sqlite
        ->query('SELECT * FROM users')
        ->fetchAll(PDO::FETCH_NAMED)
);