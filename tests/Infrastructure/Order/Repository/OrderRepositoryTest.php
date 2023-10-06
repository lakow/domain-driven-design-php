<?php

use Core\Domain\Checkout\Entity\Order;
use Core\Domain\Checkout\Entity\OrderItem;
use Core\Domain\Customer\Entity\Customer;
use Core\Domain\Customer\ValueObject\Address;
use Core\Domain\Product\Entity\Product;
use Core\Infrastructure\Chechout\Repository\OrderItemModel;
use Core\Infrastructure\Checkout\Repository\OrderModel;
use Core\Infrastructure\Checkout\Repository\OrderRepository;
use Core\Infrastructure\Customer\Repository\CustomerRepository;
use Core\Infrastructure\Db\{
    CustomerSchema,
    OrderItemSchema,
    OrderSchema,
    ProductSchema
};
use Core\Infrastructure\Product\Repository\ProductRepository;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
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

        CustomerSchema::run();
        ProductSchema::run();
        OrderSchema::run();
        OrderItemSchema::run();
    }

    public function test_should_create_order(): void
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: "c1", name: "John Doe");
        $address = new Address(
            street: "Street 1",
            number: "123",
            city: "City 1",
            zipCode: "12345"
        );
        $customer->setAddress($address);
        $customerRepository->create($customer);

        $productRepository = new ProductRepository;
        $product = new Product(id: "p1", name: "Product 1", price: 10);
        $productRepository->create($product);

        $orderItem = new OrderItem(
            id: "i1",
            name: "Item 1",
            price: 10,
            productId: $product->getId(),
            quantity: 2
        );

        $order = new Order(
            id: "o1",
            customerId: $customer->getId(),
            items: [$orderItem]
        );

        $orderRepository = new OrderRepository;
        $orderRepository->create($order);

        $orderModel = OrderModel::find($order->getId());
        $orderModel->load('items');

        $this->assertEquals($orderModel->toArray(), [
            'id' => $order->getId(),
            'customer_id' => $customer->getId(),
            'total' => $order->getTotal(),
            'items' => [
                [
                    'id' => $orderItem->getId(),
                    'product_id' => $orderItem->getProductId(),
                    'order_id' => $order->getId(),
                    'quantity' => $orderItem->getQuantity(),
                    'name' => $orderItem->getName(),
                    'price' => $orderItem->getPrice(),
                ]
            ]
        ]);
    }

    public function test_should_update_order()
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: "c1", name: "John Doe");
        $address = new Address(
            street: "Street 1",
            number: "123",
            city: "City 1",
            zipCode: "12345"
        );
        $customer->setAddress($address);
        $customerRepository->create($customer);

        $productRepository = new ProductRepository;
        $product = new Product(id: "p1", name: "Product 1", price: 10);
        $productRepository->create($product);

        $orderItem1 = new OrderItem(
            id: "i1",
            name: "Item 1",
            price: 10,
            productId: $product->getId(),
            quantity: 2
        );

        $order = new Order(
            id: "o1",
            customerId: $customer->getId(),
            items: [$orderItem1]
        );

        $orderRepository = new OrderRepository;
        $orderRepository->create($order);

        $orderItem2 = new OrderItem(
            id: "i2",
            name: "Item 2",
            price: 10,
            productId: $product->getId(),
            quantity: 2
        );

        $order->setItems([$orderItem1, $orderItem2]);

        $orderRepository->update($order);

        $orderModel = OrderModel::find($order->getId());
        $orderModel->load('items');

        $this->assertEquals($orderModel->toArray(), [
            'id' => $order->getId(),
            'customer_id' => $customer->getId(),
            'total' => $order->getTotal(),
            'items' => [
                [
                    'id' => $orderItem1->getId(),
                    'product_id' => $orderItem1->getProductId(),
                    'order_id' => $order->getId(),
                    'quantity' => $orderItem1->getQuantity(),
                    'name' => $orderItem1->getName(),
                    'price' => $orderItem1->getPrice(),
                ], [
                    'id' => $orderItem2->getId(),
                    'product_id' => $orderItem2->getProductId(),
                    'order_id' => $order->getId(),
                    'quantity' => $orderItem2->getQuantity(),
                    'name' => $orderItem2->getName(),
                    'price' => $orderItem2->getPrice(),
                ]
            ]
        ]);
    }

    public function test_should_find_order()
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: "c1", name: "John Doe");
        $address = new Address(
            street: "Street 1",
            number: "123",
            city: "City 1",
            zipCode: "12345"
        );
        $customer->setAddress($address);
        $customerRepository->create($customer);

        $productRepository = new ProductRepository;
        $product = new Product(id: "p1", name: "Product 1", price: 10);
        $productRepository->create($product);

        $orderItem1 = new OrderItem(
            id: "i1",
            name: "Item 1",
            price: 10,
            productId: $product->getId(),
            quantity: 2
        );

        $order = new Order(
            id: "o1",
            customerId: $customer->getId(),
            items: [$orderItem1]
        );

        $orderRepository = new OrderRepository;
        $orderRepository->create($order);

        $orderModel = $orderRepository->find($order->getId());

        $this->assertEquals($orderModel, $order);
    }

    public function test_should_find_all_orders()
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: "c1", name: "John Doe");
        $address = new Address(
            street: "Street 1",
            number: "123",
            city: "City 1",
            zipCode: "12345"
        );
        $customer->setAddress($address);
        $customerRepository->create($customer);

        $productRepository = new ProductRepository;
        $product = new Product(id: "p1", name: "Product 1", price: 10);
        $productRepository->create($product);

        $orderItem1 = new OrderItem(
            id: "i1",
            name: "Item 1",
            price: 10,
            productId: $product->getId(),
            quantity: 2
        );

        $order = new Order(
            id: "o1",
            customerId: $customer->getId(),
            items: [$orderItem1]
        );

        $orderRepository = new OrderRepository;
        $orderRepository->create($order);

        $orderModel = $orderRepository->findAll();

        $this->assertEquals($orderModel, [$order]);
    }
}
