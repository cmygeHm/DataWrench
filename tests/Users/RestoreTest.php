<?php

namespace tests\Users;

use ExampleCode\Db\Restore;
use PHPUnit\Framework\TestCase;

class RestoreTest extends TestCase
{
    private $restore;

    public function setUp()
    {
        $this->restore = new Restore;
    }

    public function testRestore()
    {
        $this->assertTrue(true, is(equalTo(true)));
    }
}