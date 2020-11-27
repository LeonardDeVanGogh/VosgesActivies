<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126153752 extends AbstractMigration
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
        $this->addSql('ALTER TABLE report ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX idx_c42f7784d6de06a6 ON report');
        $this->addSql('CREATE INDEX IDX_C42F7784F8697D13 ON report (comment_id)');
        $this->addSql('DROP INDEX idx_c42f77849d86650f ON report');
        $this->addSql('CREATE INDEX IDX_C42F7784A76ED395 ON report (user_id)');
        $this->addSql('DROP INDEX idx_c42f7784f3d025e7 ON report');
        $this->addSql('CREATE INDEX IDX_C42F778459BB1592 ON report (reason_id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77849D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784D6DE06A6 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F3D025E7 FOREIGN KEY (reason_id) REFERENCES report_reason (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784F8697D13');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A76ED395');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F778459BB1592');
        $this->addSql('ALTER TABLE report DROP deleted_at');
        $this->addSql('DROP INDEX idx_c42f778459bb1592 ON report');
        $this->addSql('CREATE INDEX IDX_C42F7784F3D025E7 ON report (reason_id)');
        $this->addSql('DROP INDEX idx_c42f7784f8697d13 ON report');
        $this->addSql('CREATE INDEX IDX_C42F7784D6DE06A6 ON report (comment_id)');
        $this->addSql('DROP INDEX idx_c42f7784a76ed395 ON report');
        $this->addSql('CREATE INDEX IDX_C42F77849D86650F ON report (user_id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F778459BB1592 FOREIGN KEY (reason_id) REFERENCES report_reason (id)');
    }
}
