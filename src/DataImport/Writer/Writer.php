<?php
declare(strict_types=1);

namespace DataWrench\DataImport\Writer;

use DataWrench\DataImport\Reader\ReaderGenerator;

interface Writer
{
    public function setReader(ReaderGenerator $generator) : void;
}
