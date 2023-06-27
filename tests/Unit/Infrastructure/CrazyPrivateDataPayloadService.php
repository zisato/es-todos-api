<?php

namespace EsTodosApi\Infrastructure;

use PHPUnit\Framework\TestCase;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\Service\PrivateDataPayloadServiceInterface;
use Zisato\EventSourcing\Aggregate\Event\PrivateData\ValueObject\Payload;

class CrazyPrivateDataPayloadServiceTest extends TestCase
{
    private array $privateDataPayloadServices;

    public function __construct(PrivateDataPayloadServiceInterface ...$privateDataPayloadServices)
    {
        $this->privateDataPayloadServices = $privateDataPayloadServices;
    }

    public function hide(Payload $payload): array
    {
        foreach ($this->privateDataPayloadServices as $privateDataPayloadService) {
            $hiddenPayload = $privateDataPayloadService->hide($payload);

            $payload = Payload::create($payload->aggregateId(), $hiddenPayload, $payload->payloadKeyCollection());
        }

        return $payload->payload();
    }

    public function show(Payload $payload): array
    {
        foreach (array_reverse($this->privateDataPayloadServices) as $privateDataPayloadService) {
            $shownPayload = $privateDataPayloadService->hide($payload);

            $payload = Payload::create($payload->aggregateId(), $shownPayload, $payload->payloadKeyCollection());
        }

        return $payload->payload();
    }
}