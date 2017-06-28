<?php

namespace ExampleCode;

require __DIR__ . '/../vendor/autoload.php';

use ExampleCode\DataImport\Entity\User;
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

$csvReader = new CsvReader;
if (!$csvReader->open(__DIR__ . '/users.csv')) {
    return;
}

$restore = new SqlWriter($sqlite, new User);
$restore->setReader($csvReader);
$restore->restore();

print_r(
    $sqlite
        ->query('SELECT * FROM users')
        ->fetchAll(PDO::FETCH_NAMED)
);
