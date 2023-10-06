<?php 

namespace Core\Infrastructure\Customer\Repository;

use Core\Domain\Customer\Entity\Customer;
use Core\Domain\Customer\ValueObject\Address;
use Domain\Customer\Repository\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function create($entity): void
    {
        if (!$entity instanceof Customer) {
            throw new \InvalidArgumentException('Invalid entity class');
        }

        CustomerModel::create([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'street' => $entity->getAddress()->street,
            'number' => $entity->getAddress()->number,
            'zipcode' => $entity->getAddress()->zipCode,
            'city' => $entity->getAddress()->city,
            'active' => $entity->isActive(),
            'reward_points' => $entity->getRewardPoints()
        ]);
    }

    public function update($entity): void
    {
        if (!$entity instanceof Customer) {
            throw new \InvalidArgumentException('Invalid entity class');
        }

        $customer = CustomerModel::find($entity->getId());
        $customer->name = $entity->getName();
        $customer->street = $entity->getAddress()->street;
        $customer->number = $entity->getAddress()->number;
        $customer->zipcode = $entity->getAddress()->zipCode;
        $customer->city = $entity->getAddress()->city;
        $customer->active = $entity->isActive();
        $customer->reward_points = $entity->getRewardPoints();
        $customer->save();
    }

    public function find(string $int): Customer
    {
        $productModel = CustomerModel::findOrFail($int);

        $customer = new Customer($productModel->id, $productModel->name);

        $customer->setAddress(new Address(
            $productModel->street,
            $productModel->number,
            $productModel->city,
            $productModel->zipcode
        ));

        $customer->addRewardPoints($productModel->reward_points);

        if ($productModel->active) {
            $customer->activate();
        }

        return $customer;
    }

    public function findAll(): array
    {
        $customersModel = CustomerModel::all();

        return array_map(function ($customerModel) {
            $customer = new Customer(
                $customerModel['id'],
                $customerModel['name']
            );

            $customer->setAddress(new Address(
                $customerModel['street'],
                $customerModel['number'],
                $customerModel['city'],
                $customerModel['zipcode']
            ));

            $customer->addRewardPoints($customerModel['reward_points']);

            if ($customerModel['active']) {
                $customer->activate();
            }
            return $customer;
        }, $customersModel->toArray());
    }
}
