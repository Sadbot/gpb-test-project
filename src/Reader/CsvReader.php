<?php

namespace App\Reader;

use App\DTO\CsvDTO;


class CsvReader {
    const FILE_PATH = __DIR__ . '/../input.csv';

    public $file;

    public function __construct()
    {
        $this->file = fopen(self::FILE_PATH, 'r');
        if (!$this->file) {
            throw new \Exception('Incorrect file!');
        }
    }

    public function read()  {
        $csvData = [];
        while (($data = fgetcsv($this->file, 0, ';')) !== false) {
            if ($data[0] === '#position') {
                continue;
            }
            
            $dto = new CsvDTO();
            $dto->position = $data[0];
            $dto->input = $data[1];
            $dto->title = $data[2];
            $csvData[] = $dto;
        }
        return $csvData;
    }
}