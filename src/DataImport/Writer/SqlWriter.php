<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Writer;

use ExampleCode\DataImport\Entity\Entity;
use ExampleCode\DataImport\Reader\ReaderGenerator;
use PDO;

class SqlWriter implements Writer
{
    /** @var ReaderGenerator */
    private $generator;

    /** @var PDO */
    private $connection;

    /** @var Entity */
    private $entityClassName;

    public function __construct($connection, Entity $entityClassName)
    {
        $this->connection = $connection;
        $this->entityClassName = $entityClassName;
    }

    public function setReader(ReaderGenerator $generator) : void
    {
        $this->generator = $generator;
    }

    public function restore() : void
    {
        $preparedStatement = $this->connection->prepare(
            $this->generateInsertSql()
        );

        foreach ($this->generator->records() as $record) {
            $toBind = array_combine($this->entityClassName::getPlaceholders(), $record);

            foreach ($toBind as $placeholder => $value) {
                $preparedStatement->bindValue($placeholder, $value);
            }
            $preparedStatement->execute();
        }
    }

    private function generateInsertSql()
    {
        return sprintf('
                INSERT INTO %s (%s)
                VALUES (%s)
            ',
            $this->entityClassName::getTableName(),
            $this->entityClassName::getSqlStatementFieldNames(),
            $this->entityClassName::getSqlStatementPlaceholders()
        );
    }
}
