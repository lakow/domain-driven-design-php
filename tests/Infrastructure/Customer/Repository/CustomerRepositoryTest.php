<?php

use Core\Domain\Customer\Entity\Customer;
use Core\Domain\Customer\ValueObject\Address;
use Core\Infrastructure\Customer\Repository\CustomerModel;
use Core\Infrastructure\Customer\Repository\CustomerRepository;
use Core\Infrastructure\Db\CustomerSchema;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class CustomerRepositoryTest extends TestCase
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
    }

    public function test_should_create_a_customer()
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: '1', name: 'Customer 1');

        $address = new Address(
            street: 'Street 1',
            number: '123',
            zipCode: '12345',
            city: 'City 1'
        );

        $customer->setAddress($address);

        $customerRepository->create($customer);

        $customerModel = CustomerModel::findOrFail($customer->getId());

        $this->assertEquals([
            'id' => $customer->getId(),
            'name' => $customer->getName(),
            'street' => $customer->getAddress()->street,
            'number' => $customer->getAddress()->number,
            'zipcode' => $customer->getAddress()->zipCode,
            'city' => $customer->getAddress()->city,
            'active' => $customer->isActive(),
            'reward_points' => $customer->getRewardPoints()
        ], $customerModel->toArray());
    }

    public function test_should_update_a_customer()
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: '1', name: 'Customer 1');

        $address = new Address(
            street: 'Street 1',
            number: '123',
            zipCode: '12345',
            city: 'City 1'
        );

        $customer->setAddress($address);

        $customerRepository->create($customer);

        $customer->changeName('Customer 2');
        $customer->activate();
        $customer->addRewardPoints(10);

        $customerRepository->update($customer);

        $customerModel = CustomerModel::findOrFail($customer->getId());

        $this->assertEquals([
            'id' => $customer->getId(),
            'name' => $customer->getName(),
            'street' => $customer->getAddress()->street,
            'number' => $customer->getAddress()->number,
            'zipcode' => $customer->getAddress()->zipCode,
            'city' => $customer->getAddress()->city,
            'active' => $customer->isActive(),
            'reward_points' => $customer->getRewardPoints()
        ], $customerModel->toArray());
    }

    public function test_should_find_a_customer()
    {
        $customerRepository = new CustomerRepository;
        $customer = new Customer(id: '1', name: 'Customer 1');

        $address = new Address(
            street: 'Street 1',
            number: '123',
            zipCode: '12345',
            city: 'City 1'
        );

        $customer->setAddress($address);

        $customerRepository->create($customer);

        $customerModel = $customerRepository->find($customer->getId());

        $this->assertEquals($customer, $customerModel);
    }

    public function test_should_find_all_customers()
    {
        $customerRepository = new CustomerRepository;

        $customer = new Customer(id: "1", name: "Customer 1");
        $address = new Address(
            street: 'Street 1',
            number: '123',
            zipCode: '12345',
            city: 'City 1'
        );
        $customer->setAddress($address);

        $customer2 = new Customer(id: "2", name: "Customer 2");
        $address2 = new Address(
            street: 'Street 2',
            number: '456',
            zipCode: '67890',
            city: 'City 2'
        );
        $customer2->setAddress($address2);
        
        $customerRepository->create($customer);
        $customerRepository->create($customer2);

        $customerModels = $customerRepository->findAll();

        $this->assertEquals([$customer, $customer2], $customerModels);
    }
}