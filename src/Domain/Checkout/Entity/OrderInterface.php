<?php

namespace Core\Domain\Checkout\Entity;

interface OrderInterface
{
    public function __construct(
        string $id,
        string $customerId,
        array $items,
    );
}
