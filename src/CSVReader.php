<?php

class CSVReader
{
    private $filePath;
    private $headers;
    private $data;

    /**
     * Initialiase the CsvReader Object
     *
     * @param string $filePath
    */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->headers = null;
        $this->data = null;

        if(!$this->isValidFile($filePath)) {
            throw new Exception('FilePath provided is not valid');
        }
    }

    /**
     * Get the headers of the csv file
     *
     * @return array
    */
    public function getHeaders() : array
    {
        if ($this->headers === null) {
            $this->readToArray();
        }

        return $this->headers;
    }

    /**
     * Get the csv as an associative array
     *
     * @return array
    */
    public function asArray() : array
    {
        if ($this->data === null) {
            $this->readToArray();
        }

        return $this->data;
    }

    /**
     * Check if the file path provided is a valid csv file
     *
     * @param string $filePath
     * @return bool
    */
    private function isValidFile(string $filePath) : bool
    {
        if (substr($filePath, -4) !== '.csv') {
            return false;
        }

        if (!file_exists($filePath)) {
            return false;
        }

        return true;
    }

    /**
     * Reads the csv file into an associative array.
     * Stored in the $this->data variable.
     *
     * @return bool if the function is successful
    */
    private function readToArray() : bool
    {
        if (!$handle = fopen($this->filePath, 'r')) {
            return false;
        }

        $result = null;
        $headers = null;

        while ($row = fgetcsv($handle)) {
            if ($headers === null) {
                $headers = $row;
                continue;
            }

            $newRow = [];
            for ($col = 0; $col < count($row); $col++) {
                $newRow[$headers[$col]] = $row[$col];
            }

            $result[] = $newRow;
        }

        fclose($handle);

        $this->headers = $headers;
        $this->data = $result;

        return true;
    }
}

?>
