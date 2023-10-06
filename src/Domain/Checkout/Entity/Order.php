<?php

namespace Core\Domain\Checkout\Entity;

class Order implements OrderInterface
{
    public function __construct(
        private string $id,
        private string $customerId,
        private array $items,
    ) {
        $this->validate();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    private function validate(): bool
    {
        if (empty($this->id)) {
            throw new \InvalidArgumentException('Order id cannot be empty');
        }

        if (empty($this->customerId)) {
            throw new \InvalidArgumentException('Order customerId cannot be empty');
        }

        if (empty($this->items)) {
            throw new \InvalidArgumentException('Order items cannot be empty');
        }

        foreach ($this->items as $item) {
            if (!$item instanceof OrderItem) {
                throw new \InvalidArgumentException('Order item must be an instance of OrderItem');
            }

            if ($item->getQuantity() <= 0) {
                throw new \InvalidArgumentException('Order item quantity must be greater than zero');
            }
        }

        return true;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
        $this->validate();
    }

    public function getTotal(): float
    {
        return array_reduce($this->items, function ($total, $item) {
            return $total + $item->getTotal();
        }, 0);
    }
}
