<?php
declare(strict_types=1);

namespace ExampleCode\Db;

use Generator;

interface DataProviderGenerator
{
    public function open(string $path) : bool;

    public function records() : Generator;
}
