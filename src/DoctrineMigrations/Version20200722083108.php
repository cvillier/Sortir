<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722083108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE photo');
        $this->addSql('ALTER TABLE lieux CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE rue rue VARCHAR(30) DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE sorties CHANGE no_lieu_id no_lieu_id INT DEFAULT NULL, CHANGE etat_id etat_id INT DEFAULT NULL, CHANGE campus_id campus_id INT DEFAULT NULL, CHANGE organisateur_id organisateur_id INT DEFAULT NULL, CHANGE duree duree INT DEFAULT NULL, CHANGE url_photo url_photo VARCHAR(250) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON DEFAULT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(15) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE actif actif TINYINT(1) DEFAULT NULL, CHANGE photo_name photo_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, photo_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lieux CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE rue rue VARCHAR(30) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE latitude latitude DOUBLE PRECISION DEFAULT \'NULL\', CHANGE longitude longitude DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sorties CHANGE no_lieu_id no_lieu_id INT DEFAULT NULL, CHANGE etat_id etat_id INT DEFAULT NULL, CHANGE campus_id campus_id INT DEFAULT NULL, CHANGE organisateur_id organisateur_id INT DEFAULT NULL, CHANGE duree duree INT DEFAULT NULL, CHANGE url_photo url_photo VARCHAR(250) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE utf8mb4_bin, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE telephone telephone VARCHAR(15) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE actif actif TINYINT(1) DEFAULT \'NULL\', CHANGE photo_name photo_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
