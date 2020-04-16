<?php

namespace App\DTO;

class GraphDTO
{
    public ?string $input = null;
    public ?string $position = null;
    public ?string $price = null;
    public int $inheritLevel = 0;
    /** @var GraphDTO[] */
    public array $children = [];
}