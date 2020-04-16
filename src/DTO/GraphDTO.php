<?php

namespace App\DTO;

class GraphDTO
{
    public ?string $input = null;
    public ?string $position = null;
    public ?string $price = null;
    /** @var GraphDTO[] */
    public array $children = [];
}