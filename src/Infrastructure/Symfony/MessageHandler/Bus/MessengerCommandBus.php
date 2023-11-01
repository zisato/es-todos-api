<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Symfony\MessageHandler\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\DelayedMessageHandlingException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Zisato\CQRS\WriteModel\Service\CommandBus;
use Zisato\CQRS\WriteModel\ValueObject\Command;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private readonly MessageBusInterface $commandBus
    ) {
    }

    public function handle(Command $command): void
    {
        $envelope = new Envelope($command);

        try {
            $envelope = $this->commandBus->dispatch($envelope);
        } catch (HandlerFailedException $exception) {
            $firstException = current($exception->getNestedExceptions());

            throw $firstException;
        } catch (DelayedMessageHandlingException $exception) {
            $firstException = current($exception->getExceptions());

            throw $firstException;
        }
    }
}
