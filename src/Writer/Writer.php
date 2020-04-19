<?php
declare(strict_types=1);

namespace DataWrench\Writer;

use DataWrench\Reader\Reader;

interface Writer
{
    public function setReader(Reader $generator) : void;
}
