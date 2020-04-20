<?php
declare(strict_types=1);

namespace DataWrench\IntegrationTest;

use DataWrench\Entity\FieldsMap;
use DataWrench\Reader\CsvReader;
use DataWrench\Reader\JsonReader;
use DataWrench\UnitTest\Env\FileBuilder;
use DataWrench\Writer\SqlWriter;
use Exception;
use JsonStreamingParser\Listener\SimpleObjectQueueListener;
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

    public function Json()
    {
        $fh = fopen(__DIR__ . '/example.json', 'r');
        $jsonReader = new JsonReader($fh, new FieldsMap(['id', 'age', 'name', 'gender']));
        $writer = new SqlWriter($this->sqlite, self::TABLE_NAME);
        $writer->setReader($jsonReader);

        $writer->export();

//        self::assertEquals([
//            ['name' => 'Настасья', 'sex' => 'female', 'age' => 24],
//            ['name' => 'Timur', 'sex' => 'male', 'age' => 30],
//        ], $this->fetchResult());
//
//        $stream = fopen('example.json', 'r');
//        $listener = new SimpleObjectQueueListener(function($v) {
//            $m = $v;
//        });
//        try {
//            $parser = new \JsonStreamingParser\Parser($stream, $listener);
//            $parser->parse();
//            fclose($stream);
//        } catch (Exception $e) {
//            fclose($stream);
//            throw $e;
//        }
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
