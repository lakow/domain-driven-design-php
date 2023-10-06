<?php

namespace Core\Domain\Checkout\Factory;

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Checkout\Entity\OrderItem;

class OrderFactory
{
    public function create(array $orderData): Order
    {
        $items = array_map(function ($item) {
            return new OrderItem(
                id: $item['id'],
                name: $item['name'],
                price: $item['price'],
                productId: $item['productId'],
                quantity: $item['quantity']
            );
        }, $orderData['items']);

        return new Order(
            id: uniqid(),
            customerId: $orderData['customerId'],
            items: $items
        );
    }
}
