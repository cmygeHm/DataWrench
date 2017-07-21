<?php
declare(strict_types=1);

namespace DataWrench\DataImport\Reader;

use Generator;

interface ReaderGenerator
{
    public function open(string $path) : bool;

    public function records() : Generator;
}
