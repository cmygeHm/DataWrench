<?php
declare(strict_types=1);

namespace DataWrench\IntegrationTest\Reader;

use DataWrench\Entity\Entity;
use DataWrench\Entity\FieldsMap;
use DataWrench\Reader\CsvReader;
use DataWrench\UnitTest\Env\FileBuilder;
use PHPUnit\Framework\TestCase;
use TypeError;

class CsvReaderTest extends TestCase
{
    public function testReadCsvFile()
    {
        $fh = FileBuilder::create()
            ->addLine("Lady Gaga;female;24")
            ->addLine("Timur;male;30")
            ->build();

        $csvReader = new CsvReader($fh, new FieldsMap(['name', 'sex', 'age']));
        $records = iterator_to_array($csvReader->read());

        $this->assertEquals([
            new Entity([
                'name' => 'Lady Gaga',
                'sex' => 'female',
                'age' => '24',
            ]),
            new Entity([
                'name' => 'Timur',
                'sex' => 'male',
                'age' => '30',
            ])
        ], $records);
    }

    public function testException()
    {
        $this->expectException(\TypeError::class);

        $fh = FileBuilder::create()
            ->addLine("Timur;male;30")
            ->build();

        $invalidFieldsMap = $this->createMock(FieldsMap::class);
        $invalidFieldsMap->method('mapSourceToDestination')
            ->willReturn(null);

        $csvReader = new CsvReader($fh, $invalidFieldsMap);
        $csvReader->read()->current();
    }

    public function testClosingFileHandlerOnException()
    {
        $fh = FileBuilder::create()
            ->addLine("Timur;male;30")
            ->build();

        $invalidFieldsMap = $this->createMock(FieldsMap::class);
        $invalidFieldsMap->method('mapSourceToDestination')
            ->willReturn(null);

        $csvReader = new CsvReader($fh, $invalidFieldsMap);
        try {
            $csvReader->read()->current();
        } catch (TypeError $e) {
            // nothing
        }

        $this->assertFalse(is_resource($fh));
    }
}
