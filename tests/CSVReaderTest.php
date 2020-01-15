<?php

require_once('src/CSVReader.php');

use PHPUnit\Framework\TestCase;

class CSVReaderTest extends TestCase
{
    const TEST_CSV_PATH = 'data/test.csv';

    /** @var CSVReader $testCsv */
    private $testCsv;

    public function setUp()
    {
        $this->testCsv = new CSVReader(self::TEST_CSV_PATH);
    }

    public function tearDown()
    {
        unset($this->testCsv);
    }

    /**
     *  @expectedException Exception
    */
    public function testNonExistingFileException()
    {
        $csv = new CSVReader('data/non_existing_file.csv');
    }

    /**
     *  @expectedException Exception
    */
    public function testNonCsvFileException()
    {
        $csv = new CSVReader('data/non_csv_file.docx');
    }

    /**
     * Test the correct headers are stored from reading the csv file
    */
    public function testHeaders()
    {
        $this->assertEquals(
            ['id','firstName','lastName','email'],
            $this->testCsv->getHeaders()
        );
    }

    /**
     * Test a given record exists when read from the csv file
     *
     * @dataProvider recordProvider
    */
    public function testRecordExists(array $record)
    {
        $this->assertContains($record, $this->testCsv->asArray());
    }

    /**
     * Provides test records to see if they exist when they are read in
     * @see CSVReaderTest::testRecordExists
     *
     * @return array the records to test
    */
    public function recordProvider() : array
    {
        return [
            [[
                'id' => '1',
                'firstName' => 'daniel',
                'lastName' => 'smith',
                'email' => 'daniel.smith@magic42.co.uk',
            ]],
            [[
                'id' => '2',
                'firstName' => 'bob',
                'lastName' => 'marley',
                'email' => 'bob.marley@email.com',
            ]],
            [[
                'id' => '3',
                'firstName' => 'jess',
                'lastName' => 'jones',
                'email' => 'jessica.jones99@email.com',
            ]],
        ];
    }
}
