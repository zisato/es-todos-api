<?php

declare(strict_types=1);

namespace EsTodosApi\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Zisato\EventSourcing\Infrastructure\Aggregate\Event\PrivateData\Crypto\DBALSecretKeyStore;
use Zisato\EventSourcing\Infrastructure\Aggregate\Event\PrivateData\Repository\DBALPrivateDataRepository;
use Zisato\EventSourcing\Infrastructure\Aggregate\Event\Store\DBALEventStore;
use Zisato\EventSourcing\Infrastructure\Aggregate\Snapshot\Store\DBALSnapshotStore;

final class Version20230612200000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof MySQLPlatform,
            "Migration can only be executed safely on 'mysql'."
        );

        $this->addSql(DBALEventStore::TABLE_SCHEMA);
        $this->addSql(DBALSnapshotStore::TABLE_SCHEMA);
        $this->addSql(DBALSecretKeyStore::TABLE_SCHEMA);
        $this->addSql(DBALPrivateDataRepository::TABLE_SCHEMA);
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            ! $this->connection->getDatabasePlatform() instanceof MySQLPlatform,
            "Migration can only be executed safely on 'mysql'."
        );

        $this->addSql('DROP TABLE ' . DBALEventStore::TABLE_NAME);
        $this->addSql('DROP TABLE ' . DBALSnapshotStore::TABLE_NAME);
    }
}
