<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Entity;

abstract class SqlEntity
{
    abstract public static function getTableName();

    abstract public static function getSqlStatementFieldNames();

    abstract public static function getSqlStatementPlaceholders();

    abstract public static function getPlaceholders();
}
