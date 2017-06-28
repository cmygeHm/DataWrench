<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Entity;

abstract class SqlEntity
{
    abstract public static function getTableName() : string;

    abstract public static function getSqlStatementFieldNames() : string;

    abstract public static function getSqlStatementPlaceholders() : string;

    abstract public static function getPlaceholders() : array;
}
