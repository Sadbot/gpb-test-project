<?php

namespace App\Repository;

use App\DTO\GraphDTO;
use App\Graph\ProductGraph;
use PDO;

class ProductRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * TODO переделать на batch insert
     * Рекурсивная функция по записи продуктов из графа в базу
     *
     * @param GraphDTO[] $productDTOS
     * @param int|null $parentId
     */
    public function insertIterativelyGraph(array $productDTOS, ?int $parentId = null)
    {
        foreach ($productDTOS as $productDTO) {
            $lastInsertId = $this->insertProduct($productDTO, $parentId);
            $productDTO->dbId = $lastInsertId;

            $this->insertIterativelyGraph($productDTO->children, $lastInsertId);
        }
    }

    public function insertProduct(GraphDTO $graphDTO, ?int $parentId): int
    {
        $query = "INSERT INTO products (position, input, price, parent_id) 
                    VALUES (:position, :input, :price, :parent_id)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':position', $graphDTO->position);
        $stmt->bindParam(':input', $graphDTO->input);
        $stmt->bindParam(':price', $graphDTO->price);
        $stmt->bindParam(':parent_id', $parentId);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }
}