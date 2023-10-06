<?php

namespace Core\Domain\Product\Event;

use Core\Domain\Shared\Event\EventInterface;

class ProductCreatedEvent implements EventInterface
{
    public function __construct(
        private \DateTime $dataTimeOccurred,
        private $eventData
    ) { }
}
