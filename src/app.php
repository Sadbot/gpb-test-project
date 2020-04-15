<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Reader\CsvReader;

$reader = new CsvReader;
$dtoArray = $reader->read();

var_dump($dtoArray);