<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240721221617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create api_user table to manage authentication';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE api_user (id UUID NOT NULL, user_identifier VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC64A0BAD0494586 ON api_user (user_identifier)');
        $this->addSql('COMMENT ON COLUMN api_user.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN api_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN api_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE api_user');
    }
}
