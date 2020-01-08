<?php

require_once('src/CSVReader.php');

use PHPUnit\Framework\TestCase;

class CSVReaderTest extends TestCase
{
  private $testCsv;

  public function setUp()
  {
    $this->testCsv = new CSVReader('data/test.csv');
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

  public function testHeaders()
  {
    $this->assertEquals(
      ['id','firstName','lastName','email'],
      $this->testCsv->getHeaders()
    );
  }

  /**
   * @dataProvider recordProvider
   */
  public function testRecordExists(array $record)
  {
    $this->assertContains($record, $this->testCsv->asArray());
  }

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
