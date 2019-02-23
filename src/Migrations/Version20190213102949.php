<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190213102949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis_poste ADD montant_ht DOUBLE PRECISION NOT NULL, ADD montant_mo DOUBLE PRECISION NOT NULL, ADD cout_total INT NOT NULL');
        $this->addSql('ALTER TABLE devis_sous_poste ADD montant_ht DOUBLE PRECISION NOT NULL, ADD montant_mo DOUBLE PRECISION NOT NULL, ADD cout_total INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis_poste DROP montant_ht, DROP montant_mo, DROP cout_total');
        $this->addSql('ALTER TABLE devis_sous_poste DROP montant_ht, DROP montant_mo, DROP cout_total');
    }
}
