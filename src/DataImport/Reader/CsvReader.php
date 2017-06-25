<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Reader;

use Generator;

class CsvReader implements ReaderGenerator
{
    const DELIMITER = ';';

    /** @var resource */
    private $fh;

    public function open(string $path) : bool
    {
        $this->fh = fopen($path, 'r');
        return $this->fh !== false;
    }

    public function records() : Generator
    {
        while (($csvData = fgetcsv($this->fh)) !== false) {
            yield str_getcsv(array_pop($csvData), self::DELIMITER);
        }
    }
}
