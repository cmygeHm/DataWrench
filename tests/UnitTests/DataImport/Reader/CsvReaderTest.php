<?php
declare(strict_types=1);

namespace tests\UnitTests\DataImport\Entity;

use DataWrench\DataImport\Reader\CsvReader;
use PHPUnit\Framework\TestCase;
use tests\UnitTests\Env\FileBuilder;

class CsvReaderTest extends TestCase
{
    public function testReadCsvFile()
    {
        $fh = FileBuilder::create()
            ->addLine("user name;female;24")
            ->addLine("Timur;male;30")
            ->build();

        $csvReader = new CsvReader($fh);
        $records = iterator_to_array($csvReader->records());

        $this->assertContains(['user name', 'female', 24], $records);
        $this->assertContains(['Timur', 'male', 30], $records);
    }
}
