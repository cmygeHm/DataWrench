<?php
declare(strict_types=1);

namespace DataWrench\Reader;

use DataWrench\Entity\Entity;
use DataWrench\Entity\FieldsMap;
use Generator;

class CsvReader implements Reader
{
    const DELIMITER = ';';

    /** @var resource */
    private $fh;

    /**  @var FieldsMap */
    private $fieldsMap;

    public function __construct($fileHandler, FieldsMap $fieldsMap)
    {
        $this->fh = $fileHandler;
        $this->fieldsMap = $fieldsMap;
    }

    public function read() : Generator
    {
        while (($csvRow = fgetcsv($this->fh, $length = null, self::DELIMITER)) !== false) {
            yield Entity::create(
                $this->fieldsMap->mapSourceToDestination($csvRow)
            );
        }
    }
}
