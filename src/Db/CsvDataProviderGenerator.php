<?php

namespace ExampleCode\Db;

class CsvDataProviderGenerator implements IDataProviderGenerator
{
    const DELIMITER = ';';

    /** @var resource */
    private $fh;

    public function open($path)
    {
        $this->fh = fopen($path, 'r');
        return $this->fh !== false;
    }

    public function records()
    {
        while (($csvData = fgetcsv($this->fh)) !== false) {
            yield str_getcsv(array_pop($csvData), self::DELIMITER);
        }
    }
}