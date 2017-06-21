<?php

namespace ExampleCode\Db;

use Generator;

interface DataProviderGenerator
{
    /**
     * @return Generator
     */
    public function records();
}
