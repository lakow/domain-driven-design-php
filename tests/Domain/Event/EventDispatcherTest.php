<?php

use Core\Domain\Product\Event\Handler\SendEmailWhenProductIsCreatedHandler;
use Core\Domain\Product\Event\ProductCreatedEvent;
use Core\Domain\Shared\Event\EventDispatcher;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    public function test_should_register_an_event_handler()
    {
        $eventDispatcher = new EventDispatcher;
        $eventHandler = new SendEmailWhenProductIsCreatedHandler();
        $eventDispatcher->register('ProductCreatedEvent', $eventHandler);

        $eventDispatcherHandlers = $eventDispatcher->getEventHandlers();

        $this->assertNotEmpty($eventDispatcherHandlers);
        $this->assertCount(1, $eventDispatcherHandlers['ProductCreatedEvent']);
        $this->assertSame($eventHandler, $eventDispatcherHandlers['ProductCreatedEvent'][0]);
    }

    public function test_should_unregister_an_event_handler()
    {
        $eventDispatcher = new EventDispatcher;
        $eventHandler = new SendEmailWhenProductIsCreatedHandler();
        $eventDispatcher->register('ProductCreatedEvent', $eventHandler);
        $eventDispatcherHandlers = $eventDispatcher->getEventHandlers();

        $this->assertCount(1, $eventDispatcherHandlers['ProductCreatedEvent']);

        $eventDispatcher->unregister('ProductCreatedEvent', $eventHandler);
        $eventDispatcherHandlers = $eventDispatcher->getEventHandlers();

        $this->assertCount(0, $eventDispatcherHandlers['ProductCreatedEvent']);
    }

    public function test_should_unregister_all_event_handlers()
    {
        $eventDispatcher = new EventDispatcher;
        $eventHandler = new SendEmailWhenProductIsCreatedHandler();
        $eventDispatcher->register('ProductCreatedEvent', $eventHandler);
        $eventDispatcherHandlers = $eventDispatcher->getEventHandlers();

        $this->assertCount(1, $eventDispatcherHandlers['ProductCreatedEvent']);

        $eventDispatcher->unregisterAll();

        $this->assertEmpty($eventDispatcher->getEventHandlers());
    }

    public function test_should_notify_all_event_handlers()
    {
        $eventDispatcher = new EventDispatcher;
        $eventHandler = new SendEmailWhenProductIsCreatedHandler();
        $eventDispatcher->register('ProductCreatedEvent', $eventHandler);

        $event = new ProductCreatedEvent(new DateTime(), [
            'name' => 'Product 1',
            'description' => 'Product 1 description',
            'price' => 1000
        ]);
        $eventDispatcher->notify($event);

        $this->expectOutputString('Sending email to ...');
    }
}
