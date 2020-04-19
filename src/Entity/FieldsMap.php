<?php
declare(strict_types=1);

namespace DataWrench\Entity;

class FieldsMap
{
    private $fieldsMap;

    public function __construct(array $fieldsMap)
    {
        $this->fieldsMap = $fieldsMap;
    }

    public function mapSourceToDestination(array $source) : array
    {
        return array_combine(array_values($this->fieldsMap), array_values($source));
    }
}
