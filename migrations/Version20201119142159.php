<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119142159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77849D86650F');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784D6DE06A6');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784F3D025E7');
        $this->addSql('DROP INDEX IDX_C42F77849D86650F ON report');
        $this->addSql('DROP INDEX IDX_C42F7784D6DE06A6 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784F3D025E7 ON report');
        $this->addSql('ALTER TABLE report ADD comment_id INT NOT NULL, ADD user_id INT NOT NULL, ADD reason_id INT NOT NULL, ADD deleted_at DATETIME DEFAULT NULL, DROP comment_id, DROP user_id, DROP reason_id');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77849D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784D6DE06A6 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F3D025E7 FOREIGN KEY (reason_id) REFERENCES report_reason (id)');
        $this->addSql('CREATE INDEX IDX_C42F77849D86650F ON report (user_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784D6DE06A6 ON report (comment_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784F3D025E7 ON report (reason_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784D6DE06A6');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77849D86650F');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784F3D025E7');
        $this->addSql('DROP INDEX IDX_C42F7784D6DE06A6 ON report');
        $this->addSql('DROP INDEX IDX_C42F77849D86650F ON report');
        $this->addSql('DROP INDEX IDX_C42F7784F3D025E7 ON report');
        $this->addSql('ALTER TABLE report ADD comment_id INT NOT NULL, ADD user_id INT NOT NULL, ADD reason_id INT NOT NULL, DROP comment_id, DROP user_id, DROP reason_id, DROP deleted_at');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784D6DE06A6 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77849D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F3D025E7 FOREIGN KEY (reason_id) REFERENCES report_reason (id)');
        $this->addSql('CREATE INDEX IDX_C42F7784D6DE06A6 ON report (comment_id)');
        $this->addSql('CREATE INDEX IDX_C42F77849D86650F ON report (user_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784F3D025E7 ON report (reason_id)');
    }
}
