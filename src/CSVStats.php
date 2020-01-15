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
     * @param string $header The column to calculate from
     * @return float
     */
    public function sum(string $header) : float
    {
        return array_sum($this->readColumn($header));
    }

    /**
     * Get the maximum of all values in a column in the CSV.
     *
     * @param string $header The column to calculate from
     * @return float
     */
    public function max(string $header) : float
    {
        return max($this->readColumn($header));
    }

    /* Get the average of all values in a column in the CSV.
    *
    * @param string $header The column to calculate from
    * @return float
    */
    public function mean(string $header) : float
    {
        return $this->sum($header) / $this->countRows();
    }

    public function stddev(string $header) : float
    {
        $mean = $this->mean($header);

        $sumSquareDistFromMean = 0;
        foreach ($this->readColumn($header) as $val) {
            $sumSquareDistFromMean += pow($val - $mean, 2);
        }

        return $sumSquareDistFromMean / $this->countRows();
    }

    /**
     * Reads all the values in the given column.
     *
     * @param string $header
     */
    private function readColumn(string $header) : array
    {
        if (!in_array($header, $this->reader->getHeaders())) {
            throw new Exception('Header does not exist as part of CSV');
        }

        return array_column($this->reader->asArray(), $header);
    }
}
