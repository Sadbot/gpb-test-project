<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Reader\CsvReader;
use App\Database\Connection;
use App\Graph\ProductGraph;
use App\Repository\ProductRepository;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$reader = new CsvReader;
$productsList = $reader->read();

$productGraph = new ProductGraph;
foreach ($productsList as $csvDTO) {
    $productGraph->createEmptyAndAdd($csvDTO);
}

$conn = new Connection;

$rep = new ProductRepository($conn->pdo);
$rep->insertIterativelyGraph($productGraph->graph);

echo $productGraph->printToConsole();

