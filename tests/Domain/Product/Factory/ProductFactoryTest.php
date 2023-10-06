<?php

use Core\Domain\Product\Entity\Product;
use Core\Domain\Product\Entity\ProductB;
use Core\Domain\Product\Factory\ProductFactory;
use PHPUnit\Framework\TestCase;

class ProductFactoryTest extends TestCase
{
    public function test_should_create_a_product_type_a()
    {
        $productFactory = new ProductFactory();
        $product = $productFactory->create('a', 'Product A', 10.00);

        $this->assertInstanceOf(Product::class, $product);
    }

    public function test_should_create_a_product_type_b()
    {
        $productFactory = new ProductFactory();
        $product = $productFactory->create('b', 'Product B', 10.00);

        $this->assertInstanceOf(ProductB::class, $product);
    }

    public function test_should_throw_an_exception_when_invalid_product_type()
    {
        $this->expectException(\Exception::class);

        $productFactory = new ProductFactory();
        $productFactory->create('c', 'Product C', 10.00);
    }
}
