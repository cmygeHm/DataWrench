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
            'name,sex,age'
        );
    }

    /**
     * @test
     */
    public function getSqlStatementPlaceholders()
    {
        $this->assertEquals(
            User::getSqlStatementPlaceholders(),
            ':name,:sex,:age'
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
                ':name',
                ':sex',
                ':age',
            ]
        );
    }
}
