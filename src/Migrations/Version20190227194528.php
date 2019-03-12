<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227194528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bordereau_livraison ADD chantier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bordereau_livraison ADD CONSTRAINT FK_D480CB41D0C0049D FOREIGN KEY (chantier_id) REFERENCES chantier (id)');
        $this->addSql('CREATE INDEX IDX_D480CB41D0C0049D ON bordereau_livraison (chantier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bordereau_livraison DROP FOREIGN KEY FK_D480CB41D0C0049D');
        $this->addSql('DROP INDEX IDX_D480CB41D0C0049D ON bordereau_livraison');
        $this->addSql('ALTER TABLE bordereau_livraison DROP chantier_id');
    }
}
