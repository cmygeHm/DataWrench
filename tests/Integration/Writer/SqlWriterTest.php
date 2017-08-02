<?php
declare(strict_types=1);

use DataWrench\Entity\User;
use DataWrench\Reader\CsvReader;
use DataWrench\UnitTest\Env\FileBuilder;
use DataWrench\Writer\SqlWriter;
use PHPUnit\Framework\TestCase;

class SqlWriterTest extends TestCase
{
    /** @var PDO */
    private $sqlite;

    public function setUp()
    {
        $this->sqlite = new PDO('sqlite::memory:');
    }
    public function testSom()
    {
        $this->sqlite->exec('
            CREATE TABLE users (
                name VARCHAR,
                sex VARCHAR,
                age INTEGER 
            );
        ');

        $fh = FileBuilder::create()
            ->addLine('Настасья;female;24')
            ->addLine('Timur;male;30')
            ->build();

        $restore = new SqlWriter($this->sqlite, new User);
        $restore->setReader(new CsvReader($fh));
        $restore->restore();

        $records = $this->sqlite
            ->query('SELECT * FROM users')
            ->fetchAll(PDO::FETCH_NAMED);

        $this->assertContains(['name' => 'Настасья', 'sex' => 'female', 'age' => 24], $records);
        $this->assertContains(['name' => 'Timur', 'sex' => 'male', 'age' => 30], $records);
    }
}
