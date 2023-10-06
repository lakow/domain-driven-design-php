<?php

use Core\Domain\Product\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_should_throw_error_when_id_is_empty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product id cannot be empty');

        new Product('', 'Product 1', 10.0);
    }

    public function test_should_throw_error_when_name_is_empty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name cannot be empty');

        new Product('product-1', '', 10.0);
    }

    public function test_should_throw_error_when_price_is_less_than_zero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Price must be greater than zero');

        new Product('product-1', 'Product 1', -10.0);
    }

    public function test_should_change_name()
    {
        $product = new Product('product-1', 'Product 1', 10.0);
        $product->changeName('Product 2');

        $this->assertEquals('Product 2', $product->getName());
    }

    public function test_should_change_price()
    {
        $product = new Product('product-1', 'Product 1', 10.0);
        $product->changePrice(20.0);

        $this->assertEquals(20.0, $product->getPrice());
    }
}
