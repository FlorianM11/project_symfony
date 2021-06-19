<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618134559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lease DROP FOREIGN KEY FK_E6C77495B9575F5A');
        $this->addSql('DROP INDEX IDX_E6C77495B9575F5A ON lease');
        $this->addSql('ALTER TABLE lease CHANGE property_id_id property_id INT NOT NULL');
        $this->addSql('ALTER TABLE lease ADD CONSTRAINT FK_E6C77495549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_E6C77495549213EC ON lease (property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lease DROP FOREIGN KEY FK_E6C77495549213EC');
        $this->addSql('DROP INDEX IDX_E6C77495549213EC ON lease');
        $this->addSql('ALTER TABLE lease CHANGE property_id property_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE lease ADD CONSTRAINT FK_E6C77495B9575F5A FOREIGN KEY (property_id_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_E6C77495B9575F5A ON lease (property_id_id)');
    }
}
