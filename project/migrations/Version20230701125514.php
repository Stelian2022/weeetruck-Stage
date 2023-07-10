<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230701125514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD entreprise_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES `entreprise` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A4AEAFEA ON ticket (entreprise_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A76ED395 ON ticket (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A4AEAFEA');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A76ED395');
        $this->addSql('DROP INDEX IDX_97A0ADA3A4AEAFEA ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3A76ED395 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP entreprise_id, DROP user_id');
    }
}
