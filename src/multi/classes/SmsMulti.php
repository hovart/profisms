<?php

namespace Multi;
class SmsMulti
{
    const ERROR_FILE = 1;
    const ERROR_NOERROR = 0;
    const ERROR_ERROR = 1;
    const ERROR_CAPTION = 1;

    public int $id;
    public int $idUser = 1;

    public $file = 'c72c66f025_list_1';
    public $removefirst;
    public $filetype = 'CSV';
    public string $csv = '{"delimiter": ",","enclosure":"\""}';
    public int $duplicity = 0;
    public $original_columns;
    public $original_rows;
    public $removediacritics;

    public function __construct($id = 0)
    {
        $this->id = $id;

    }

    public static function GetFileReader($name)
    {
        $filename = $_FILES[$name]['name'];

        // Use pathinfo() to get the file extension
        $fileInfo = pathinfo($filename);
        $fileExtension = strtoupper($fileInfo['extension']);
        return $fileExtension;
    }

    public function Save(array $data, $fd)
    {
        // Write the data (array values) to the file
        fputcsv($fd, array_values($data));

    }

}