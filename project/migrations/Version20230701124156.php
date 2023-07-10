<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230701124156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis ADD entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES `entreprise` (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52BA4AEAFEA ON devis (entreprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BA4AEAFEA');
        $this->addSql('DROP INDEX IDX_8B27C52BA4AEAFEA ON devis');
        $this->addSql('ALTER TABLE devis DROP entreprise_id');
    }
}
