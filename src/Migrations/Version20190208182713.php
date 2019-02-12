<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190208182713 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE devis_ligne (id INT AUTO_INCREMENT NOT NULL, poste_id INT DEFAULT NULL, sous_poste_id INT DEFAULT NULL, ordre INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_41D3C6A7A0905086 (poste_id), INDEX IDX_41D3C6A7A8DE64D3 (sous_poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_ligne_sous_poste (id INT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_poste (id INT AUTO_INCREMENT NOT NULL, estimation_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, ordre INT NOT NULL, INDEX IDX_6AAA128FF35F62F2 (estimation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estimation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_ligne_article (id INT NOT NULL, reference VARCHAR(255) DEFAULT NULL, designation LONGTEXT NOT NULL, quantite DOUBLE PRECISION NOT NULL, pub_ht DOUBLE PRECISION NOT NULL, unite_prix VARCHAR(255) NOT NULL, remise DOUBLE PRECISION DEFAULT NULL, type_remise VARCHAR(255) DEFAULT NULL, taux_tva DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devis_ligne_commentaires (id INT NOT NULL, texte LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A7A0905086 FOREIGN KEY (poste_id) REFERENCES devis_poste (id)');
        $this->addSql('ALTER TABLE devis_ligne ADD CONSTRAINT FK_41D3C6A7A8DE64D3 FOREIGN KEY (sous_poste_id) REFERENCES devis_ligne (id)');
        $this->addSql('ALTER TABLE devis_ligne_sous_poste ADD CONSTRAINT FK_57C9194BF396750 FOREIGN KEY (id) REFERENCES devis_ligne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_poste ADD CONSTRAINT FK_6AAA128FF35F62F2 FOREIGN KEY (estimation_id) REFERENCES estimation (id)');
        $this->addSql('ALTER TABLE devis_ligne_article ADD CONSTRAINT FK_880EB447BF396750 FOREIGN KEY (id) REFERENCES devis_ligne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_ligne_commentaires ADD CONSTRAINT FK_B5DE5503BF396750 FOREIGN KEY (id) REFERENCES devis_ligne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A7A8DE64D3');
        $this->addSql('ALTER TABLE devis_ligne_sous_poste DROP FOREIGN KEY FK_57C9194BF396750');
        $this->addSql('ALTER TABLE devis_ligne_article DROP FOREIGN KEY FK_880EB447BF396750');
        $this->addSql('ALTER TABLE devis_ligne_commentaires DROP FOREIGN KEY FK_B5DE5503BF396750');
        $this->addSql('ALTER TABLE devis_ligne DROP FOREIGN KEY FK_41D3C6A7A0905086');
        $this->addSql('ALTER TABLE devis_poste DROP FOREIGN KEY FK_6AAA128FF35F62F2');
        $this->addSql('DROP TABLE devis_ligne');
        $this->addSql('DROP TABLE devis_ligne_sous_poste');
        $this->addSql('DROP TABLE devis_poste');
        $this->addSql('DROP TABLE estimation');
        $this->addSql('DROP TABLE devis_ligne_article');
        $this->addSql('DROP TABLE devis_ligne_commentaires');
    }
}
