<?php

use Core\Domain\Customer\Entity\Customer;
use Core\Domain\Customer\Factory\CustomerFactory;
use Core\Domain\Customer\ValueObject\Address;
use PHPUnit\Framework\TestCase;

class CustomerFactoryTest extends TestCase
{
    public function test_should_create_client()
    {
        $customerFactory = new CustomerFactory();
        $customer = $customerFactory->create('John Doe');
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function test_should_create_client_with_address()
    {
        $customerFactory = new CustomerFactory();
        $address = new Address('Street 1', 'City', 'State', 'Country', 'Zipcode');
        $customer = $customerFactory->createWithAddress('John Doe', $address);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertInstanceOf(Address::class, $customer->getAddress());
    }
}
