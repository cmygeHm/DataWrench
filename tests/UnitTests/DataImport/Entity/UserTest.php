<?php

namespace tests\UnitTests\DataImport\Entity;

use DataWrench\DataImport\Entity\User;
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

    /**
     * @test
     */
    public function getSqlStatementPlaceholders()
    {
        $this->assertEquals(
            User::getSqlStatementPlaceholders(),
            ':login,:password'
        );
    }

    /**
     * @test
     */
    public function getPlaceholders()
    {
        $this->assertEquals(
            User::getPlaceholders(),
            [
                ':login',
                ':password',
            ]
        );
    }
}