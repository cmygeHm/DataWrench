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
    private $sqlEntity;

    public function __construct($connection, SqlEntity $sqlEntity)
    {
        $this->connection = $connection;
        $this->sqlEntity = $sqlEntity;
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

        $placeholders = $this->sqlEntity::getPlaceholders();
        $placeholdersCount = count($placeholders);
        foreach ($this->generator->records() as $record) {
            if (count($record) != $placeholdersCount) {
                // todo: log it
                // todo: протестировать все краевые случаи с количеством значений и плейсхолдеров
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
            $this->sqlEntity::getTableName(),
            $this->sqlEntity::getSqlStatementFieldNames(),
            $this->sqlEntity::getSqlStatementPlaceholders()
        );
    }
}
