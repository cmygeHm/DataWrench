<?php

namespace ExampleCode\Db;

use PDO;

class Restore
{
    /** @var DataProviderGenerator */
    private $generator;

    /** @var PDO */
    private $connection;

    public function setDataProviderGenerator(DataProviderGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function setPdoConnection(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function restore()
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
     * @return array
     */
    public function fetchRestored()
    {
        return $this->connection
            ->query('SELECT * FROM users')
            ->fetchAll(PDO::FETCH_NAMED);
    }
}
