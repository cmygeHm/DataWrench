<?php

namespace ExampleCode\Db;

use Generator;

interface IDataProviderGenerator
{
    /**
     * @return Generator
     */
    public function records();
}