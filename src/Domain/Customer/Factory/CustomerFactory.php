<?php

namespace Core\Domain\Customer\Factory;

use Core\Domain\Customer\Entity\Customer;
use Core\Domain\Customer\ValueObject\Address;

class CustomerFactory
{
    public function create(string $name)
    {
        return new Customer(uniqid(), $name);
    }

    public function createWithAddress(string $name, Address $address)
    {
        $customer = new Customer(uniqid(), $name);
        $customer->setAddress($address);
        return $customer;
    }
}
