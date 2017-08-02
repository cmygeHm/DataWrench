<?php
declare(strict_types=1);

namespace DataWrench\Entity;

class User extends SqlEntity
{
    private const FIELDS = [
        'name',
        'sex',
        'age',
    ];

    public static function getTableName() : string
    {
        return 'users';
    }

    public static function getSqlStatementFieldNames() : string
    {
        return implode(',', self::FIELDS);
    }

    public static function getSqlStatementPlaceholders() : string
    {
        return implode(',', self::getPlaceholders());
    }

    /**
     * @return string[]
     */
    public static function getPlaceholders() : array
    {
        return array_map(function(string $field) {
            return ':' . $field;
        }, self::FIELDS);
    }
}
