<?php
declare(strict_types=1);

namespace DataWrench\Reader;

use Generator;

interface ReaderGenerator
{
    public function records() : Generator;
}
