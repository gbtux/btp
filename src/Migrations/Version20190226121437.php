<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190226121437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE estimation DROP INDEX FK_D0527024D0C0049D, ADD UNIQUE INDEX UNIQ_D0527024D0C0049D (chantier_id)');
        $this->addSql('ALTER TABLE estimation ADD montant_mo DOUBLE PRECISION NOT NULL, ADD cout_total INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE estimation DROP INDEX UNIQ_D0527024D0C0049D, ADD INDEX FK_D0527024D0C0049D (chantier_id)');
        $this->addSql('ALTER TABLE estimation DROP montant_mo, DROP cout_total');
    }
}
