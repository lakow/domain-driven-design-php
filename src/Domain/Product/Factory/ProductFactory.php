<?php

namespace Core\Domain\Product\Factory;

use Core\Domain\Product\Entity\Product;
use Core\Domain\Product\Entity\ProductB;

class ProductFactory
{
    public function create(string $type, string $name, float $price)
    {
        switch($type) {
            case 'a':
                return new Product(uniqid(), $name, $price);
            case 'b':
                return new ProductB(uniqid(), $name, $price);
            default:
                throw new \Exception('Invalid product type');
        }
    }
}
