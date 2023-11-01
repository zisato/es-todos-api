<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure;

use Zisato\EventSourcing\Aggregate\Event\PrivateData\Adapter\PayloadEncoderAdapterInterface;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\ValueObject\PayloadKeyCollection;

final class CrazyPayloadEncoderAdapter implements PayloadEncoderAdapterInterface
{
    private readonly array $payloadEncoderAdapters;

    public function __construct(PayloadEncoderAdapterInterface ...$payloadEncoderAdapters)
    {
        $this->payloadEncoderAdapters = $payloadEncoderAdapters;
    }

    public function show(string $aggregateId, PayloadKeyCollection $payloadKeyCollection, array $payload): array
    {
        foreach (array_reverse($this->payloadEncoderAdapters) as $payloadEncoderAdapter) {
            $payload = $payloadEncoderAdapter->show($aggregateId, $payloadKeyCollection, $payload);
        }

        return $payload;
    }

    public function hide(string $aggregateId, PayloadKeyCollection $payloadKeyCollection, array $payload): array
    {
        foreach ($this->payloadEncoderAdapters as $payloadEncoderAdapter) {
            $payload = $payloadEncoderAdapter->hide($aggregateId, $payloadKeyCollection, $payload);
        }

        return $payload;
    }
}
