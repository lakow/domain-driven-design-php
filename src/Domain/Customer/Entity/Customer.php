<?php

namespace Core\Domain\Customer\Entity;

use Core\Domain\Customer\ValueObject\Address;
use Core\Domain\Product\Entity\CustomerInterface;

class Customer implements CustomerInterface
{
    private int $rewardPoints = 0;
    private bool $active = false;

    public function __construct(
        private string $id,
        private string $name,
        private ?Address $address = null
    ) {
        $this->validate();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function getRewardPoints(): int
    {
        return $this->rewardPoints;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
        $this->validate();
    }

    private function validate(): bool
    {
        if (empty($this->id)) {
            throw new \InvalidArgumentException('Customer id cannot be empty');
        }

        if (empty($this->name)) {
            throw new \InvalidArgumentException('Customer name cannot be empty');
        }
        return true;
    }

    public function activate(): void
    {
        if (!$this->address) {
            throw new \InvalidArgumentException('Address is mandatory to activate a customer');
        }
        $this->active = true;
    }

    public function deactivate(): void
    {
        $this->active = false;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function addRewardPoints(int $points): void
    {
        $this->rewardPoints += $points;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }
}
