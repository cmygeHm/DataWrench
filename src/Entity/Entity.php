<?php
declare(strict_types=1);

namespace DataWrench\Entity;

class Entity
{
    private $keyValues;

    private $keys;

    public function __construct(array $keyValues)
    {
        $this->keyValues = $keyValues;
        $this->keys = array_keys($this->keyValues);
    }

    public function getFieldNames() : array
    {
        return $this->keys;
    }

    public function getValues() : array
    {
        return array_values($this->keyValues);
    }

    public static function create(array $keyValues) : self
    {
        return new self($keyValues);
    }
}
