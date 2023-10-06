<?php

use Core\Domain\Product\Entity\Product;
use Core\Domain\Product\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function test_should_change_the_prices_of_all_products()
    {
        $product1 = new Product('product-1', 'Product 1', 10.0);
        $product2 = new Product('product-2', 'Product 2', 20.0);

        $products = [$product1, $product2];

        ProductService::increasePrice($products, 100);

        $this->assertEquals(20.0, $product1->getPrice());
        $this->assertEquals(40.0, $product2->getPrice());
    }
}
