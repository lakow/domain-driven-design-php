<?php

namespace Core\Domain\Shared\Event;

class EventDispatcher implements EventDispatcherInterface
{
    private $eventHandlers = [];

    public function getEventHandlers(): array
    {
        return $this->eventHandlers;
    }
    
    public function notify(EventInterface $event): void
    {
        $eventName = class_basename($event);
        if (isset($this->eventHandlers[$eventName])) {
            foreach ($this->eventHandlers[$eventName] as $eventHandler) {
                $eventHandler->handle($event);
            }
        }
    }

    public function register(string $eventName, EventHandlerInterface $eventHandler): void
    {
        $this->eventHandlers[$eventName][] = $eventHandler;
    }

    public function unregister(string $eventName, EventHandlerInterface $eventHandler): void
    {
        if (isset($this->eventHandlers[$eventName])) {
            foreach ($this->eventHandlers[$eventName] as $key => $handler) {
                if (get_class($handler) === get_class($eventHandler)) {
                    unset($this->eventHandlers[$eventName][$key]);
                }
            }
        }
    }

    public function unregisterAll(): void
    {
        $this->eventHandlers = [];
    }
}
