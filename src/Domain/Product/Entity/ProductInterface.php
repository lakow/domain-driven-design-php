<?php

namespace Core\Domain\Product\Entity;

interface ProductInterface
{
    public function __construct(
        string $id,
        string $name,
        float $price,
    );
}