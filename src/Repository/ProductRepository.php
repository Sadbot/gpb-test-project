<?php

namespace App\Repository;

use App\Graph\ProductGraph;
use PDO;

class ProductRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertGraph(ProductGraph $productGraph)
    {

    }
}