<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190215215040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnel ADD specialite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE2195E0F0 FOREIGN KEY (specialite_id) REFERENCES personnel_specialite (id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DE2195E0F0 ON personnel (specialite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE2195E0F0');
        $this->addSql('DROP INDEX IDX_A6BCF3DE2195E0F0 ON personnel');
        $this->addSql('ALTER TABLE personnel DROP specialite_id');
    }
}
