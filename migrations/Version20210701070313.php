<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701070313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tenant_lease (tenant_id INT NOT NULL, lease_id INT NOT NULL, INDEX IDX_F95798A19033212A (tenant_id), INDEX IDX_F95798A1D3CA542C (lease_id), PRIMARY KEY(tenant_id, lease_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tenant_lease ADD CONSTRAINT FK_F95798A19033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenant_lease ADD CONSTRAINT FK_F95798A1D3CA542C FOREIGN KEY (lease_id) REFERENCES lease (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C462D3CA542C');
        $this->addSql('DROP INDEX IDX_4E59C462D3CA542C ON tenant');
        $this->addSql('ALTER TABLE tenant DROP lease_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tenant_lease');
        $this->addSql('ALTER TABLE tenant ADD lease_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tenant ADD CONSTRAINT FK_4E59C462D3CA542C FOREIGN KEY (lease_id) REFERENCES lease (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4E59C462D3CA542C ON tenant (lease_id)');
    }
}
