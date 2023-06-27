<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Symfony\MessageHandler\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\DelayedMessageHandlingException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Zisato\CQRS\ReadModel\Service\QueryBus;
use Zisato\CQRS\ReadModel\ValueObject\Query;
use Zisato\CQRS\ReadModel\ValueObject\QueryResult;

class MessengerQueryBus implements QueryBus
{
    private MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function ask(Query $query): QueryResult
    {
        $envelope = new Envelope($query);

        try {
            $envelope = $this->queryBus->dispatch($envelope);
        } catch (HandlerFailedException $exception) {
            $firstException = current($exception->getNestedExceptions());

            throw $firstException;
        } catch (DelayedMessageHandlingException $exception) {
            $firstException = current($exception->getExceptions());

            throw $firstException;
        }

        /** @var HandledStamp|null $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        if ($handledStamp === null) {
            throw new \LogicException(sprintf(
                'At least one handler for "%s" should exists',
                \get_class($envelope->getMessage())
            ));
        }

        /** @var QueryResult $result */
        $result = $handledStamp->getResult();

        return $result;
    }
}
