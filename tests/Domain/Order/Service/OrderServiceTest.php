<?php

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Checkout\Entity\OrderItem;
use Core\Domain\Checkout\Service\OrderService;
use Core\Domain\Customer\Entity\Customer;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function test_should_place_an_order()
    {
        $customer = new Customer('customer-id', 'Customer Name');
        $item1 = new OrderItem('item-1', 'Product 1', 20.0, 'product-1', 1);

        $order = OrderService::placeOrder($customer, [$item1]);

        $this->assertEquals(10.0, $customer->getRewardPoints());
        $this->assertEquals(20.0, $order->getTotal());
    }

    public function test_should_get_total_of_all_orders()
    {
        $item1 = new OrderItem('item-1', 'Product 1', 20.0, 'product-1', 1);
        $item2 = new OrderItem('item-2', 'Product 2', 30.0, 'product-2', 2);

        $order1 = new Order('order-1', 'customer-1', [$item1]);
        $order2 = new Order('order-2', 'customer-2', [$item2]);

        $total = OrderService::total([$order1, $order2]);

        $this->assertEquals(80.0, $total);
    }
}