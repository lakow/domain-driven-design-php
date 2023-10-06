<?php

namespace Core\Domain\Product\Entity;

use Core\Domain\Customer\ValueObject\Address;

interface CustomerInterface
{
    public function __construct(
        string $id,
        string $name,
        ?Address $address = null
    );
}
