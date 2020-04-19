<?php
declare(strict_types=1);

namespace DataWrench\Reader;

use Generator;

interface Reader
{
    public function read() : Generator;
}
