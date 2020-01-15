<?php

require_once('src/CSVReader.php');

class CSVStats
{
    protected $reader;

    public function __construct(CSVReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Get the number of columns in the CSV.
     *
     * @return int
     */
    public function countCols() : int
    {
        return count($this->reader->getHeaders());
    }

    /**
     * Get the number of rows in the CSV.
     *
     * @return int
     */
    public function countRows() : int
    {
        return count($this->reader->asArray());
    }

    /**
     * Get the sum of all values in a column in the CSV.
     *
     * @param $header The column to calculate from
     * @return float
     */
    public function sum(string $header) : float
    {
        if (!in_array($header, $this->reader->getHeaders())) {
            throw new Exception('Header does not exist as part of CSV');
        }

        $total = 0;

        $col = array_column($this->reader->asArray(), $header);

        return array_sum($col);
    }
}
