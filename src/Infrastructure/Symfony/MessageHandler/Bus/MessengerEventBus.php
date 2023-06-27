<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Symfony\MessageHandler\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Zisato\EventSourcing\Aggregate\Event\Bus\EventBusInterface;
use Zisato\EventSourcing\Aggregate\Event\EventInterface;

class MessengerEventBus implements EventBusInterface
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function handle(EventInterface $event): void
    {
        $this->eventBus->dispatch($event, [new DispatchAfterCurrentBusStamp()]);
    }
}
