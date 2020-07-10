<?php


namespace App\Utils;


class CSV
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function csvToArray(): array
    {
        $array = array();
        $fields = array();
        $i = 0;
        $handle = @fopen($this->path, "r");
        if ($handle) {
            while (($row = fgetcsv($handle, 4096, ";")) !== false) {
                //get first row
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                //add the name of the column as a second dimension
                foreach ($row as $k => $value) {
                    $array[$i][$fields[$k]] = $value;
                }
                $i++;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }
        return $array;
    }
}
