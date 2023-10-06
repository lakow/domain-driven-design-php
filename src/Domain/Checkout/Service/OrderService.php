<?php 

namespace Core\Domain\Checkout\Service;

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Customer\Entity\Customer;

class OrderService
{
    /**
     * Place an order
     * 
     * @param Customer $customer: Customer who places the order
     * @param array<OrderItem> $orderItems: List of items to order
     * 
     * @return Order
     */
    public static function placeOrder(Customer $customer, array $orderItems): Order
    {
        if (empty($orderItems)) {
            throw new \InvalidArgumentException('Order items cannot be empty');
        }

        $order = new Order('id-order', $customer->getId(), $orderItems);
        $customer->addRewardPoints($order->getTotal() / 2);
        
        return $order;
    }

    /**
     * Calculate the total of a list of orders
     * 
     * @param array<Order> $orders: List of orders
     * 
     * @return float
     */
    public static function total(array $orders): float
    {
        return array_reduce($orders, function ($total, Order $order) {
            return $total + $order->getTotal();
        }, 0);
    }
}