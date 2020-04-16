<?php

namespace App\Graph;

use App\DTO\CsvDTO;
use App\DTO\GraphDTO;

class ProductGraph
{
    /** @var GraphDTO[] */
    public array $graph = [];

    /**
     * Заполняем граф с данными иерархически,
     * в случае когда родительских элементов нет,
     * то оставляем пустыми
     *
     * @param string[] $paragraphs
     * @param CsvDTO $csvDTO
     * @return ProductGraph
     */
    public function createEmptyAndAdd(array $paragraphs, CsvDTO $csvDTO)
    {
        $graphLevel = &$this->graph;
        $lastParagraphKey = array_key_last($paragraphs);
        foreach ($paragraphs as $idx => $paragraph) {
            if (isset($graphLevel[$paragraph]) && $idx !== $lastParagraphKey) {
                $graphLevel = &$graphLevel[$paragraph]->children;
                continue;
            }

            $graphDTO = new GraphDTO;
            if ($idx === $lastParagraphKey) {
                $graphDTO->input = $csvDTO->input;
                $graphDTO->position = $csvDTO->position;
                $graphDTO->price = $csvDTO->title;
            }

            $graphLevel[$paragraph] = $graphDTO;
            $graphLevel = &$graphDTO->children;
        }

        return $this;
    }
}