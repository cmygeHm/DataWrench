<?php
declare(strict_types=1);

namespace DataWrench\IntegrationTest;

use DataWrench\Entity\FieldsMap;
use DataWrench\Reader\CsvReader;
use DataWrench\UnitTest\Env\FileBuilder;
use DataWrench\Writer\SqlWriter;
use PDO;
use PHPUnit\Framework\TestCase;

class ReadWriteTest extends TestCase
{
    /** @var PDO */
    private $sqlite;

    private const TABLE_NAME = 'test_table';

    public function setUp()
    {
        $this->sqlite = new PDO('sqlite::memory:');
        $this->sqlite->exec(sprintf(
            'create table %s (name varchar, sex varchar, age integer)',
            self::TABLE_NAME
        ));
    }

    public function test_csvReader_sqlWriter()
    {
        $fh = FileBuilder::create()
            ->addLine('Настасья;female;24')
            ->addLine('Timur;male;30')
            ->build();

        $csvReader = new CsvReader($fh, new FieldsMap(['name', 'sex', 'age']));
        $writer = new SqlWriter($this->sqlite, self::TABLE_NAME);
        $writer->setReader($csvReader);

        $writer->export();

        self::assertEquals([
            ['name' => 'Настасья', 'sex' => 'female', 'age' => 24],
            ['name' => 'Timur', 'sex' => 'male', 'age' => 30],
        ], $this->fetchResult());
    }

    private function fetchResult() : array
    {
        $stmt = $this->sqlite->prepare(sprintf(
            "SELECT * FROM %s",
            self::TABLE_NAME
        ));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
