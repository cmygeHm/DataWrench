<?php

namespace tests\UnitTests\DataImport\Entity;

use ExampleCode\DataImport\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function getSqlStatementFieldNames()
    {
        $this->assertEquals(
            User::getSqlStatementFieldNames(),
            'login,password'
        );
    }
}