<?php
declare(strict_types=1);

namespace tests\UnitTests\DataImport\Entity;

use DataWrench\DataImport\Reader\CsvReader;
use PHPUnit\Framework\TestCase;

class CsvReaderTest extends TestCase
{
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
            $this->csvReader->open(__DIR__ . uniqid())
        );
    }
}
