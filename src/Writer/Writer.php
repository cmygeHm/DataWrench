<?php
declare(strict_types=1);

namespace DataWrench\Writer;

use DataWrench\Reader\ReaderGenerator;

interface Writer
{
    public function setReader(ReaderGenerator $generator) : void;
}
