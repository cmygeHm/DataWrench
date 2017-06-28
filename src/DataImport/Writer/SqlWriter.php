<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Writer;

use ExampleCode\DataImport\Entity\SqlEntity;
use ExampleCode\DataImport\Reader\ReaderGenerator;
use PDO;

class SqlWriter implements Writer
{
    /** @var ReaderGenerator */
    private $generator;

    /** @var PDO */
    private $connection;

    /** @var SqlEntity */
    private $entityClassName;

    public function __construct($connection, SqlEntity $entityClassName)
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

        $placeholders = $this->entityClassName::getPlaceholders();
        $placeholdersCount = count($placeholders);
        foreach ($this->generator->records() as $record) {
            if (count($record) < $placeholdersCount) {
                // todo: log it
                continue;
            }
            $toBind = array_combine($placeholders, $record);

            foreach ($toBind as $placeholder => $value) {
                $preparedStatement->bindValue($placeholder, $value);
            }
            $preparedStatement->execute();
        }
    }

    private function generateInsertSql() : string
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
