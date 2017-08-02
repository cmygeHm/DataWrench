<?php

namespace DataWrench;

require __DIR__ . '/../vendor/autoload.php';

use DataWrench\Entity\User;
use DataWrench\Reader\CsvReader;
use DataWrench\Writer\SqlWriter;
use PDO;

$sqlite = new PDO('sqlite::memory:');
$sqlite->exec('
    CREATE TABLE users (
        login VARCHAR,
        password VARCHAR
    );
');

$fh = fopen(__DIR__ . '/users.csv', 'r');
$csvReader = new CsvReader($fh);

$restore = new SqlWriter($sqlite, new User);
$restore->setReader($csvReader);
$restore->restore();

print_r(
    $sqlite
        ->query('SELECT * FROM users')
        ->fetchAll(PDO::FETCH_NAMED)
);
