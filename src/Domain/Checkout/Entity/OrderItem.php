<?php 

namespace Core\Domain\Checkout\Entity;

class OrderItem
{
    public function __construct(
        private string $id,
        private string $name,
        private float $price,
        private string $productId,
        private int $quantity,
    ) { }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}
