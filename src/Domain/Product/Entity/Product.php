<?php

namespace Core\Domain\Product\Entity;

use Core\Domain\Product\Entity\ProductInterface;

class Product implements ProductInterface
{
    public function __construct(
        private string $id,
        private string $name,
        private float $price,
    ) {
        $this->validate();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getPrice(): float
    {
        return (float) $this->price;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
        $this->validate();
    }

    public function changePrice(float $price): void
    {
        $this->price = $price;
        $this->validate();
    }

    private function validate(): bool
    {
        if (empty($this->id)) {
            throw new \InvalidArgumentException('Product id cannot be empty');
        }

        if (empty($this->name)) {
            throw new \InvalidArgumentException('Product name cannot be empty');
        }

        if ($this->price < 0) {
            throw new \InvalidArgumentException('Price must be greater than zero');
        }

        return true;
    }
}
