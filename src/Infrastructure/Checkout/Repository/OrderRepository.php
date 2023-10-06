<?php

namespace Core\Infrastructure\Checkout\Repository;

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Checkout\Entity\OrderItem;
use Domain\Shared\Repository\RepositoryInterface;
use stdClass;

class OrderRepository implements RepositoryInterface
{
    public function create($entity): void
    {
        if (!$entity instanceof Order) {
            throw new \InvalidArgumentException('Invalid entity class');
        }

        $orderModel = OrderModel::create([
            'id' => $entity->getId(),
            'customer_id' => $entity->getCustomerId(),
            'total' => $entity->getTotal(),
        ]);

        $orderModel->items()->createMany(
            array_map(
                fn ($item) => [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'product_id' => $item->getProductId(),
                    'quantity' => $item->getQuantity(),
                ],
                $entity->getItems()
            )
        );
    }

    public function update($entity): void
    {
        if (!$entity instanceof Order) {
            throw new \InvalidArgumentException('Invalid entity class');
        }

        $orderModel = OrderModel::find($entity->getId());

        $orderModel->update([
            'id' => $entity->getId(),
            'customer_id' => $entity->getCustomerId(),
            'total' => $entity->getTotal(),
        ]);

        $orderModel->items()->delete();
        $orderModel->items()->createMany(
            array_map(
                fn ($item) => [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'product_id' => $item->getProductId(),
                    'quantity' => $item->getQuantity(),
                ],
                $entity->getItems()
            )
        );
    }

    public function find(string $id): Order
    {
        $orderModel = OrderModel::findOrFail($id);
        $orderModel->load('items');
        return $this->hydrate($orderModel);
    }
    
    public function findAll(): array
    {
        $list = [];
        $orderModels = OrderModel::with('items')->get();
        foreach ($orderModels as $orderModel) {
            $list[] = $this->hydrate($orderModel);
        }
        return $list;
    }

    private function hydrate($data): Order
    {
        return new Order(
            id: $data->id,
            customerId: $data->customer_id,
            items: array_map(
                fn ($item) => new OrderItem(
                    id: $item['id'],
                    name: $item['name'],
                    price: $item['price'],
                    productId: $item['product_id'],
                    quantity: $item['quantity']
                ),
                $data->items->toArray()
            )
        );
    }
}
