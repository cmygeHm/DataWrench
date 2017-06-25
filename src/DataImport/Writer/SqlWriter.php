<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Writer;

use ExampleCode\DataImport\Reader\ReaderGenerator;
use PDO;

class SqlWriter implements Writer
{
    /** @var ReaderGenerator */
    private $generator;

    /** @var PDO */
    private $connection;

    public function setReader(ReaderGenerator $generator) : void
    {
        $this->generator = $generator;
    }

    public function setOutputResource($resource) : void
    {
        $this->connection = $resource;
    }

    public function restore() : void
    {
        $preparedStatement = $this->connection->prepare('
            INSERT INTO users (login, password)
            VALUES (:login, :password)
        ');

        foreach ($this->generator->records() as $record) {
            list($login, $password) = $record;
            $preparedStatement->bindValue(':login', $login);
            $preparedStatement->bindParam(':password', $password);
            $preparedStatement->execute();
        }
    }
}
