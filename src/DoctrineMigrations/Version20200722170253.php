<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722170253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inscriptions (sortie_id INT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_74E0281CCC72D953 (sortie_id), INDEX IDX_74E0281CA76ED395 (user_id), PRIMARY KEY(sortie_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sorties ADD motif_annulation LONGTEXT DEFAULT NULL, ADD archivee TINYINT(1) DEFAULT NULL, DROP organisateur, CHANGE etatsortie organisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_488163E8D936B2FA ON sorties (organisateur_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64978D1870D');
        $this->addSql('DROP INDEX IDX_8D93D64978D1870D ON user');
        $this->addSql('ALTER TABLE user ADD campus_id INT NOT NULL, ADD photo_name VARCHAR(255) DEFAULT NULL, DROP no_campus_id, CHANGE roles roles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AF5D55E1 ON user (campus_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('DROP INDEX IDX_488163E8D936B2FA ON sorties');
        $this->addSql('ALTER TABLE sorties ADD organisateur INT NOT NULL, DROP motif_annulation, DROP archivee, CHANGE organisateur_id etatsortie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF5D55E1');
        $this->addSql('DROP INDEX IDX_8D93D649AF5D55E1 ON user');
        $this->addSql('ALTER TABLE user ADD no_campus_id INT DEFAULT NULL, DROP campus_id, DROP photo_name, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64978D1870D FOREIGN KEY (no_campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64978D1870D ON user (no_campus_id)');
    }
}
