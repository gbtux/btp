<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190222213624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE achat_categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, raison_sociale VARCHAR(255) NOT NULL, forme_juridique VARCHAR(255) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, siren VARCHAR(255) DEFAULT NULL, code_ape VARCHAR(255) DEFAULT NULL, tva_intra VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, fournisseur_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, libelle VARCHAR(255) NOT NULL, total_ht DOUBLE PRECISION DEFAULT NULL, total_ttc DOUBLE PRECISION DEFAULT NULL, total_tva55 DOUBLE PRECISION DEFAULT NULL, total_tva10 DOUBLE PRECISION DEFAULT NULL, total_tva20 DOUBLE PRECISION DEFAULT NULL, frais DOUBLE PRECISION DEFAULT NULL, date_creation DATETIME NOT NULL, is_paid TINYINT(1) NOT NULL, date_paiement DATETIME DEFAULT NULL, date_depense DATETIME NOT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, document VARCHAR(255) DEFAULT NULL, cancelled TINYINT(1) NOT NULL, INDEX IDX_26A9845612469DE2 (category_id), INDEX IDX_26A98456670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A9845612469DE2 FOREIGN KEY (category_id) REFERENCES achat_categorie (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A9845612469DE2');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456670C757F');
        $this->addSql('DROP TABLE achat_categorie');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE achat');
    }
}
