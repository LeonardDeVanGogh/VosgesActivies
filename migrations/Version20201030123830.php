<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201030123830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_category (activity_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A646A9CF81C06096 (activity_id), INDEX IDX_A646A9CF12469DE2 (category_id), PRIMARY KEY(activity_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_category ADD CONSTRAINT FK_A646A9CF81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_category ADD CONSTRAINT FK_A646A9CF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE category_activity');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_activity (category_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_1B0E8D2112469DE2 (category_id), INDEX IDX_1B0E8D2181C06096 (activity_id), PRIMARY KEY(category_id, activity_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category_activity ADD CONSTRAINT FK_1B0E8D2112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_activity ADD CONSTRAINT FK_1B0E8D2181C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE activity_category');
    }
}
