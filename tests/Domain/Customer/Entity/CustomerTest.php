<?php

use Core\Domain\Customer\Entity\Customer;
use Core\Domain\Customer\ValueObject\Address;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_should_throw_error_when_id_is_empty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Customer id cannot be empty');
        new Customer('', 'John Doe');
    }

    public function test_should_throw_error_when_name_is_empty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Customer name cannot be empty');
        new Customer('123', '');
    }

    public function test_should_change_name()
    {
        $customer = new Customer('123', 'John Doe');
        $customer->changeName('Jane Doe');
        $this->assertEquals('Jane Doe', $customer->getName());
    }

    public function test_should_activate_customer()
    {
        $address  = new Address('Street', '123', 'City', '12345');
        $customer = new Customer('123', 'John Doe', $address);

        $customer->activate();
        $this->assertTrue($customer->isActive());
    }

    public function test_should_throw_error_when_address_is_undefined_when_you_activate_a_customer()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Address is mandatory to activate a customer');
        $customer = new Customer('123', 'John Doe');
        $customer->activate();
    }

    public function test_should_deactivate_customer()
    {
        $customer = new Customer('123', 'John Doe');
        $customer->deactivate();
        $this->assertFalse($customer->isActive());
    }

    public function test_should_add_reward_points()
    {
        $customer = new Customer('123', 'John Doe');
        $this->assertEquals(0, $customer->getRewardPoints());

        $customer->addRewardPoints(10);
        $this->assertEquals(10, $customer->getRewardPoints());

        $customer->addRewardPoints(10);
        $this->assertEquals(20, $customer->getRewardPoints());
    }
}
