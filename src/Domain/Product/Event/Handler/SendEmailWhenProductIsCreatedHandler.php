<?php

namespace Core\Domain\Product\Event\Handler;

use Core\Domain\Shared\Event\EventHandlerInterface;

class SendEmailWhenProductIsCreatedHandler implements EventHandlerInterface
{
    public function handle($event): void
    {
        print('Sending email to ...');
    }
}