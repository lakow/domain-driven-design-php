<?php

namespace Core\Domain\Product\Service;

use Core\Domain\Product\Entity\Product;

class ProductService
{
    /**
     * Increase the price of a list of products by a percentage
     * 
     * @param Product[] $products: List of products
     * @param float $percentage: Percentage to increase the price
     * 
     * @return Product[]
     */
    public static function increasePrice(array $products, float $percentage): array
    {
        return array_map(function (Product $product) use ($percentage) {
            $product->changePrice(($product->getPrice() * $percentage) / 100 + $product->getPrice());
            return $product;
        }, $products);
    }
}
