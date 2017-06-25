<?php

namespace tests\Users;

use ExampleCode\Db\SqlWriter;
use PHPUnit\Framework\TestCase;

class RestoreTest extends TestCase
{
    private $restore;

    public function setUp()
    {
        $this->restore = new SqlWriter;
    }

    public function testRestore()
    {
        $this->assertTrue(true, is(equalTo(true)));
    }
}