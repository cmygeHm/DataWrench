<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Entity;

class User extends SqlEntity
{
    private const FIELDS = [
        'login',
        'password',
    ];

    public static function getTableName()
    {
        return 'users';
    }

    public static function getSqlStatementFieldNames()
    {
        return implode(', ', self::FIELDS);
    }

    public static function getSqlStatementPlaceholders()
    {
        return implode(', ', self::getPlaceholders());
    }

    public static function getPlaceholders()
    {
        return array_map(function(string $field) {
            return ':' . $field;
        }, self::FIELDS);
    }
}
