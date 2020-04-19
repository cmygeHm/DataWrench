<?php
declare(strict_types=1);

namespace DataWrench\IntegrationTest\Reader;

use DataWrench\Entity\Entity;
use DataWrench\Entity\FieldsMap;
use DataWrench\Reader\CsvReader;
use DataWrench\UnitTest\Env\FileBuilder;
use PHPUnit\Framework\TestCase;

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
}
