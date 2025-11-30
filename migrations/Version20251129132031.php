<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251129132031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create `client` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE client
            (
                id            INT AUTO_INCREMENT                 NOT NULL,
                first_name    VARCHAR(255)                       NOT NULL,
                last_name     VARCHAR(255)                       NOT NULL,
                phone_numbers JSON     DEFAULT NULL,
                ip_v4         VARCHAR(255)                       NOT NULL,
                country       VARCHAR(255)                       NOT NULL,
                created_at    DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                updated_at    DATETIME DEFAULT NULL,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE client');
    }
}
