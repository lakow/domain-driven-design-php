<?php

namespace Core\Domain\Customer\ValueObject;

class Address 
{
    public function __construct(
        private string $street,
        private string $number,
        private string $city,
        private string $zipCode,
    ) {
        $this->validate();
    }

    public function __get(string $name)
    {
        return $this->$name;
    }

    public function validate(): bool
    {
        if (strlen($this->street) === 0) {
            throw new \InvalidArgumentException('Street is required');
        }

        if (strlen($this->number) === 0) {
            throw new \InvalidArgumentException('Number is required');
        }

        if (strlen($this->city) === 0) {
            throw new \InvalidArgumentException('City is required');
        }

        if (strlen($this->zipCode) === 0) {
            throw new \InvalidArgumentException('Zip code is required');
        }

        return true;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s, %s, %s, %s',
            $this->street,
            $this->number,
            $this->city,
            $this->zipCode,
        );
    }
}
