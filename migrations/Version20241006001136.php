<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006001136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empresas ALTER cnpj TYPE VARCHAR(14)');
        $this->addSql('ALTER TABLE empresas ALTER data_fundacao TYPE DATE');
        $this->addSql('ALTER TABLE socios_empresa ALTER cpf TYPE VARCHAR(11)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE empresas ALTER cnpj TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE empresas ALTER data_fundacao TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE socios_empresa ALTER cpf TYPE VARCHAR(255)');
    }
}
