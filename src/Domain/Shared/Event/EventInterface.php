<?php

namespace Core\Domain\Shared\Event;

use DateTime;

interface EventInterface
{
    public function __construct(DateTime $dataTimeOccurred, $eventData);
}
