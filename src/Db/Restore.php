<?php
declare(strict_types=1);

namespace ExampleCode\Db;

use PDO;

class Restore
{
    /** @var DataProviderGenerator */
    private $generator;

    /** @var PDO */
    private $connection;

    public function setDataProviderGenerator(DataProviderGenerator $generator) : void
    {
        $this->generator = $generator;
    }

    public function setPdoConnection(PDO $connection) : void
    {
        $this->connection = $connection;
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

    /**
     * @return string[]
     */
    public function fetchRestored() : array
    {
        return $this->connection
            ->query('SELECT * FROM users')
            ->fetchAll(PDO::FETCH_NAMED);
    }
}
