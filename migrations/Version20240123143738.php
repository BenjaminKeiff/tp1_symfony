<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123143738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients_organizations DROP FOREIGN KEY FK_1DF89A486288A55');
        $this->addSql('ALTER TABLE clients_organizations DROP FOREIGN KEY FK_1DF89A4AB014612');
        $this->addSql('DROP TABLE clients_organizations');
        $this->addSql('ALTER TABLE clients ADD organization_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E7432C8A3DE FOREIGN KEY (organization_id) REFERENCES organizations (id)');
        $this->addSql('CREATE INDEX IDX_C82E7432C8A3DE ON clients (organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients_organizations (clients_id INT NOT NULL, organizations_id INT NOT NULL, INDEX IDX_1DF89A486288A55 (organizations_id), INDEX IDX_1DF89A4AB014612 (clients_id), PRIMARY KEY(clients_id, organizations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE clients_organizations ADD CONSTRAINT FK_1DF89A486288A55 FOREIGN KEY (organizations_id) REFERENCES organizations (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clients_organizations ADD CONSTRAINT FK_1DF89A4AB014612 FOREIGN KEY (clients_id) REFERENCES clients (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E7432C8A3DE');
        $this->addSql('DROP INDEX IDX_C82E7432C8A3DE ON clients');
        $this->addSql('ALTER TABLE clients DROP organization_id');
    }
}
