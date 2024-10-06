<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005213659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE socios_empresa (id INT NOT NULL, empresa_id INT NOT NULL, nome VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, data_vinculo DATE NOT NULL, data_criacao TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, data_atualizacao TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, apagado BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A1C32DE521E1991 ON socios_empresa (empresa_id)');
        $this->addSql('ALTER TABLE socios_empresa ADD CONSTRAINT FK_5A1C32DE521E1991 FOREIGN KEY (empresa_id) REFERENCES empresas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE socios_empresa DROP CONSTRAINT FK_5A1C32DE521E1991');
        $this->addSql('DROP TABLE socios_empresa');
    }
}
