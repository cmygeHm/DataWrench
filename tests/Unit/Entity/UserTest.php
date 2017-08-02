<?php
declare(strict_types=1);

namespace DataWrench\UnitTest\Entity;

use DataWrench\Entity\User;
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
