<?php
declare(strict_types=1);

namespace ExampleCode\DataImport\Writer;

use ExampleCode\DataImport\Reader\ReaderGenerator;

interface Writer
{
    public function setReader(ReaderGenerator $generator) : void;
}
