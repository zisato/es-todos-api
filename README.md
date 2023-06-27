# es-todos-api

Example of a PHP application using DDD, CQRS and Event Sourcing

### Requirements
1. Docker

### Test execution
1. Install dependencies: `bin/composer.sh install`
2. Execute unit and functional test suites: `bin/test.sh`

## Explanation
This project is a simple todos rest api

### Command Bus
Implementation using Symfony Messenger

### Query Bus
Implementation using Symfony Messenger

### Event Bus
Implementation using Symfony Messenger. Async messages uses doctrine transport

## WriteModel

### Aggregates
Aggregates extends from `Zisato\EventSourcing\Aggregate\AbstractAggregateRoot`

### Aggregate Repositories
Aggregate Repository can extends from `Zisato\EventSourcing\Aggregate\Repository\AggregateRootRepository` or `Zisato\EventSourcing\Aggregate\Repository\AggregateRootRepositoryWithSnapshot`

### Events
Aggregate events extends from `Zisato\EventSourcing\Aggregate\Event\AbstractEvent`

### Upcasting
Example can be found with event `EsTodosApi\Domain\Todo\WriteModel\Event\TodoCreated`  and upcaster `EsTodosApi\Domain\Todo\WriteModel\Event\Upcaster\TodoCreatedV2Upcaster`

### Private Data
POC of event private data found in event `EsTodosApi\Domain\User\WriteModel\Event\UserCreated` for property `identification`. Private data strategy can be changed with condiguration, configuration detail below

### Decorator
Example can be found in `TODO`

## ReadModel
### Projections
Projections extends from `Zisato\Projection\ValueObject\ProjectionModel`

### Projection Repositories
Projection Repository implementation with MongoDB extending from `Zisato\Projection\Infrastructure\MongoDB\Repository\MongoDBRepository` having a `findBy` with simple criteria

## Bundles

### ApiBundle
Includes some configurable services for api development, like api problem exception listener or json schema request body validator. Default configuration:
```
# config/api.yaml

api:
  api_problem:
    enabled: true
    exception_handlers: []
  json_schema_path: %kernel.project_dir%/public/schemas/
```


### EventSourcingBundle
Handle configuration about event sourcing upcasters, snapshots and private data. Default configuration:
```
# config/event_sourcing.yaml

event_sourcing:
    event:
        version_resolver: Zisato\EventSourcing\Aggregate\Event\Version\StaticMethodVersionResolver
    snapshot:
        strategy: Zisato\EventSourcing\Aggregate\Snapshot\Strategy\AggregateRootVersionSnapshotStrategy
        service: Zisato\EventSourcing\Aggregate\Snapshot\Service\SynchronousSnapshotService
    private_data:
        payload_service: Zisato\EventSourcing\Aggregate\Event\PrivateData\Service\CryptoPrivateDataPayloadService
```