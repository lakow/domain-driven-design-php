<?php

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Checkout\Factory\OrderFactory;
use PHPUnit\Framework\TestCase;

class OrderFactoryTest extends TestCase
{
    public function test_should_create_an_order()
    {
        $orderData = [
            'customerId' => '1',
            'items' => [
                [
                    'id' => '1',
                    'name' => 'Product 1',
                    'price' => 10.00,
                    'productId' => '1',
                    'quantity' => 1,
                ],
                [
                    'id' => '2',
                    'name' => 'Product 2',
                    'price' => 20.00,
                    'productId' => '2',
                    'quantity' => 2,
                ],
            ],
        ];

        $orderFactory = new OrderFactory();
        $order = $orderFactory->create($orderData);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals('1', $order->getCustomerId());
        $this->assertCount(2, $order->getItems());
    }
}
