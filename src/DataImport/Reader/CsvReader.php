<?php
declare(strict_types=1);

namespace DataWrench\DataImport\Reader;

use Generator;

class CsvReader implements ReaderGenerator
{
    const DELIMITER = ';';

    /** @var resource */
    private $fh;

    public function __construct($fileHandler)
    {
        $this->fh = $fileHandler;
    }

    public function records() : Generator
    {
        while (($csvRow = fgetcsv($this->fh, $length = null, self::DELIMITER)) !== false) {
            yield $csvRow;
        }
    }
}
