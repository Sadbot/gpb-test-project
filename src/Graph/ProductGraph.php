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
     * то заполняем пустыми данными
     *
     * @param string[] $paragraphs
     * @param CsvDTO $csvDTO
     * @return ProductGraph
     */
    public function createEmptyAndAdd(CsvDTO $csvDTO)
    {
        $graphLevel = &$this->graph;
        $paragraphs = explode('.', $csvDTO->position);
        $lastParagraphKey = array_key_last($paragraphs);
        foreach ($paragraphs as $key => $paragraph) {
            if (isset($graphLevel[$paragraph]) && $key !== $lastParagraphKey) {
                $graphLevel = &$graphLevel[$paragraph]->children;
                continue;
            }

            $graphDTO = new GraphDTO;
            if ($key === $lastParagraphKey) {
                $graphDTO->input = $csvDTO->input;
                $graphDTO->position = $csvDTO->position;
                $graphDTO->price = $csvDTO->title;
                $graphDTO->inheritLevel = (int)$key;
            }

            $graphLevel[$paragraph] = $graphDTO;
            $graphLevel = &$graphDTO->children;
        }

        return $this;
    }

    public function printToConsole(): string
    {
        return $this->iterativeReproduceElements($this->graph);
    }

    /**
     * @param GraphDTO[] $graphDTOS
     * @return string
     */
    protected function iterativeReproduceElements(array $graphDTOS): string
    {
        $result = '';
        ksort($graphDTOS, SORT_NUMERIC);

        foreach ($graphDTOS as $graphDTO) {
            $indentation = str_repeat('  ', $graphDTO->inheritLevel);
            $result .= $indentation . "$graphDTO->position $graphDTO->input $graphDTO->price\n";

            if (!empty($graphDTO->children)) {
                $result .= $this->iterativeReproduceElements($graphDTO->children);
            }
        }

        return $result;
    }
}