<?php
declare(strict_types=1);

namespace tests\UnitTests\DataImport\Entity;

use DataWrench\DataImport\Reader\CsvReader;
use DataWrench\DataImport\Reader\ReaderGenerator;
use PHPUnit\Framework\TestCase;
use tests\UnitTests\Env\CsvFileBuilder;
class CsvReaderTest extends TestCase
{
    /** @var ReaderGenerator */
    private $csvReader;

    public function setUp()
    {
        $this->csvReader = new CsvReader();
    }

    public function testOpenPathToExistingFile()
    {
        $this->assertTrue(
            $this->csvReader->open('php://memory')
        );
    }

    public function testOpenNotExistingFile()
    {
        $this->assertFalse(
            $this->csvReader->open(uniqid())
        );
    }

    public function testReadCsvFile()
    {
        CsvFileBuilder::create()
            ->addLine("user name;female;24")
            ->addLine("Timue;male;30")
            ->build();

//        $this->csvReader->open();
    }
}
