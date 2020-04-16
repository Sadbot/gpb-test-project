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
    $paragraphs = explode('.', $csvDTO->position);
    $productGraph->createEmptyAndAdd($paragraphs, $csvDTO);
}

$conn = new Connection;
$conn->pdo->beginTransaction();
try {
    $rep = new ProductRepository($conn->pdo);
    $rep->

    $conn->pdo->commit();
} catch (Exception $ex) {
    $conn->pdo->rollBack();
}
