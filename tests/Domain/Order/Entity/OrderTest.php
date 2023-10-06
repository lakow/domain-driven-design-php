<?php

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Checkout\Entity\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function test_should_throw_error_when_id_is_empty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Order id cannot be empty');

        new Order('', 'customer-id', []);
    }

    public function test_should_throw_error_when_name_is_empty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Order customerId cannot be empty');

        new Order('order-id', '', []);
    }

    public function test_should_throw_error_when_items_is_empty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Order items cannot be empty');

        new Order('order-id', 'customer-id', []);
    }

    public function test_should_calculate_total()
    {
        $item1 = new OrderItem('item-1', 'Product 1', 10.0, 'product-1', 1);
        $item2 = new OrderItem('item-2', 'Product 2', 20.0, 'product-2', 2);

        $order1 = new Order('order-id', 'customer-id', [$item1]);
        $total = $order1->getTotal();
        $this->assertEquals(10.0, $total);

        $order2 = new Order('order-id', 'customer-id', [$item1, $item2]);
        $total = $order2->getTotal();
        $this->assertEquals(50.0, $total);
    }

    public function test_should_throw_error_if_the_item_qtd_is_less_or_equal_zero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Order item quantity must be greater than zero');

        $item = new OrderItem('item-1', 'Product 1', 10.0, 'product-1', 0);

        new Order('order-id', 'customer-id', [$item]);
    }
}
