<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108202500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bookings (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, booked_by_id INT DEFAULT NULL, started_at DATETIME NOT NULL, end_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_7A853C3581C06096 (activity_id), UNIQUE INDEX UNIQ_7A853C35F4A5BD90 (booked_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C3581C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C35F4A5BD90 FOREIGN KEY (booked_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE activity CHANGE picture picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bookings');
        $this->addSql('ALTER TABLE activity CHANGE picture picture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
