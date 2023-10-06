<?php

namespace Core\Infrastructure\Product\Repository;

use Core\Domain\Product\Entity\Product;
use Domain\Product\Repository\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function create($entity): void
    {
        if (!$entity instanceof Product) {
            throw new \InvalidArgumentException('Invalid entity class');
        }

        ProductModel::create([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'price' => $entity->getPrice()
        ]);
    }

    public function update($entity): void
    {
        if (!$entity instanceof Product) {
            throw new \InvalidArgumentException('Invalid entity class');
        }

        $productModel = ProductModel::findOrFail($entity->getId());

        $productModel->name  = $entity->getName();
        $productModel->price = $entity->getPrice();
        $productModel->save();
    }

    public function find(string $id): Product
    {
        $productModel = ProductModel::findOrFail($id);

        return new Product(
            id: $productModel->id,
            name: $productModel->name,
            price: $productModel->price
        );
    }

    public function findAll(): array
    {
        $productModels = ProductModel::all();
        return $productModels->toArray();
    }
}
