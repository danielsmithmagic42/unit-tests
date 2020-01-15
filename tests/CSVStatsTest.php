<?php

require_once('src/CSVReader.php');
require_once('src/CSVStats.php');

use PHPUnit\Framework\TestCase;

class CSVStatsTest extends TestCase
{
    /** @var string */
    const TEST_CSV_PATH = 'data/testStats.csv';

    /** @var CSVStats $stats */
    private $stats;

    public function setUp()
    {
        $this->stats = new CSVStats(new CSVReader(self::TEST_CSV_PATH));
    }

    public function tearDown()
    {
        unset($this->stats);
    }

    /**
     * Test the countRows functionality
     *
     * @covers CSVStats::countRows
     */
    public function testCountRows()
    {
        $this->assertEquals(3, $this->stats->countRows());
    }

    /**
     * Test the countCols functionality
     *
     * @covers CSVStats::countCols
     */
    public function testCountCols()
    {
        $stats = new CSVStats(new CSVReader(self::TEST_CSV_PATH));

        $this->assertEquals(4, $this->stats->countCols());
    }

    /**
     * Test that exception is thrown if an invalid header is used during sum
     *
     * @expectedException Exception
     */
    public function testSumInvalidHeader()
    {
        $this->stats->sum('invalidHeader');
    }

    /**
     * Test the sum of a column functionality works
     */
    public function testSumValidHeader()
    {
        $testHeader = "x";

        $this->assertEquals(0.90, $this->stats->sum($testHeader));
    }
}
