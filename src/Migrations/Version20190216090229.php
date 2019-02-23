<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190216090229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_task_personnel (event_task_id INT NOT NULL, personnel_id INT NOT NULL, INDEX IDX_6D288FC8E1A829 (event_task_id), INDEX IDX_6D288FC1C109075 (personnel_id), PRIMARY KEY(event_task_id, personnel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_task_personnel ADD CONSTRAINT FK_6D288FC8E1A829 FOREIGN KEY (event_task_id) REFERENCES event_task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_task_personnel ADD CONSTRAINT FK_6D288FC1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_task_personnel');
    }
}
