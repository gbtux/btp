<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190216100334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_task ADD estimation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_task ADD CONSTRAINT FK_4DB5978EF35F62F2 FOREIGN KEY (estimation_id) REFERENCES estimation (id)');
        $this->addSql('CREATE INDEX IDX_4DB5978EF35F62F2 ON event_task (estimation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_task DROP FOREIGN KEY FK_4DB5978EF35F62F2');
        $this->addSql('DROP INDEX IDX_4DB5978EF35F62F2 ON event_task');
        $this->addSql('ALTER TABLE event_task DROP estimation_id');
    }
}
