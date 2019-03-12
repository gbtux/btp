<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190224124937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bordereau_livraison ADD fournisseur_id INT NOT NULL, ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bordereau_livraison ADD CONSTRAINT FK_D480CB41670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE bordereau_livraison ADD CONSTRAINT FK_D480CB4119EB6921 FOREIGN KEY (client_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_D480CB41670C757F ON bordereau_livraison (fournisseur_id)');
        $this->addSql('CREATE INDEX IDX_D480CB4119EB6921 ON bordereau_livraison (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bordereau_livraison DROP FOREIGN KEY FK_D480CB41670C757F');
        $this->addSql('ALTER TABLE bordereau_livraison DROP FOREIGN KEY FK_D480CB4119EB6921');
        $this->addSql('DROP INDEX IDX_D480CB41670C757F ON bordereau_livraison');
        $this->addSql('DROP INDEX IDX_D480CB4119EB6921 ON bordereau_livraison');
        $this->addSql('ALTER TABLE bordereau_livraison DROP fournisseur_id, DROP client_id');
    }
}
