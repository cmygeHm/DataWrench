<?php
declare(strict_types=1);

namespace DataWrench\Writer;

use DataWrench\Entity\Entity;
use DataWrench\Reader\Reader;
use PDO;

class SqlWriter implements Writer
{
    /** @var string */
    private $tableName;

    /** @var Reader */
    private $generator;

    /** @var PDO */
    private $connection;

    public function __construct(PDO $connection, string $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    public function setReader(Reader $generator) : void
    {
        $this->generator = $generator;
    }

    public function export() : void
    {
        $firstEntity = $this->generator->read()->current();
        $preparedStatement = $this->connection->prepare(
            $this->generateInsertSql($firstEntity)
        );
        $preparedStatement->execute($firstEntity->getValues());
        foreach ($this->generator->read() as $entity) {
            $preparedStatement->execute($entity->getValues());
        }
    }

    private function generateInsertSql(Entity $entity) : string
    {
        $fieldNames = implode(', ', $entity->getFieldNames());
        $placeholders = implode(', ', array_fill(1, count($entity->getFieldNames()), '?'));

        return sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->tableName,
            $fieldNames,
            $placeholders
        );
    }
}
