<?php

use Core\Domain\Product\Entity\Product;
use Core\Infrastructure\Db\ProductSchema;
use Core\Infrastructure\Product\Repository\ProductModel;
use Core\Infrastructure\Product\Repository\ProductRepository;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        ProductSchema::run();
    }
    
    public function test_should_create_a_product()
    {
        $productRepository = new ProductRepository;
        $product = new Product(
            id: '1',
            name: 'Product 1',
            price: 10.00
        );

        $productRepository->create($product);

        $productModel = ProductModel::findOrFail('1');

        $this->assertEquals([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice()
        ], $productModel->toArray());
    }

    public function test_should_update_a_product()
    {
        $productRepository = new ProductRepository;
        $product = new Product(
            id: '1',
            name: 'Product 1',
            price: 10.00
        );

        $productRepository->create($product);

        $product->changeName('Product 2');
        $product->changePrice(20.00);

        $productRepository->update($product);

        $productModel = ProductModel::findOrFail('1');

        $this->assertEquals([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice()
        ], $productModel->toArray());
    }

    public function test_should_find_a_product()
    {
        $productRepository = new ProductRepository;
        $product = new Product(
            id: '1',
            name: 'Product 1',
            price: 10.00
        );

        $productRepository->create($product);

        $productModel = $productRepository->find('1');

        $this->assertEquals($product, $productModel);
    }

    public function test_should_find_all_product()
    {
        $productRepository = new ProductRepository;
        $product1 = new Product(
            id: '1',
            name: 'Product 1',
            price: 10.00
        );
        $productRepository->create($product1);

        $product2 = new Product(
            id: '2',
            name: 'Product 2',
            price: 20.00
        );
        $productRepository->create($product2);

        $productModels = $productRepository->findAll();

        $this->assertEquals([[
            'id' => $product1->getId(),
            'name' => $product1->getName(),
            'price' => $product1->getPrice()
        ],[
            'id' => $product2->getId(),
            'name' => $product2->getName(),
            'price' => $product2->getPrice()
        ]], $productModels);
    }
}
