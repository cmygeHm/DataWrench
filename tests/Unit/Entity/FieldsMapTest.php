<?php
declare(strict_types=1);

namespace DataWrench\UnitTest\Entity;

use DataWrench\Entity\FieldsMap;
use PHPUnit\Framework\TestCase;

class FieldsMapTest extends TestCase
{
    public function test_associativeFieldsMap()
    {
        $fieldsMap = new FieldsMap([
            'id' => 'userId',
            'name' => 'firstName',
        ]);

        $source = [
            'id' => 1,
            'name' => 'Sami',
        ];

        $result = $fieldsMap->mapSourceToDestination($source);

        self::assertEquals([
            'userId' => 1,
            'firstName' => 'Sami',
        ], $result);
    }

    public function test_sequentalFieldsMap()
    {
        $fieldsMap = new FieldsMap([
            'userId',
            'firstName',
        ]);

        $source = [
            1,
            'Sami',
        ];

        $result = $fieldsMap->mapSourceToDestination($source);

        self::assertEquals([
            'userId' => 1,
            'firstName' => 'Sami',
        ], $result);
    }

    public function test_associativeFieldsMapWithShuffleKeysOrder()
    {
        $this->markTestSkipped('для рандомного порядка ключей код не написан');

        $fieldsMap = new FieldsMap([
            'id' => 'userId',
            'name' => 'firstName',
        ]);

        $source = [
            'name' => 'Sami',
            'id' => 1,
        ];

        $result = $fieldsMap->mapSourceToDestination($source);

        self::assertEquals([
            'userId' => 1,
            'firstName' => 'Sami',
        ], $result);
    }
}
