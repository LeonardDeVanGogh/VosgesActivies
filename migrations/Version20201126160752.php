<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126160752 extends AbstractMigration
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
        $this->addSql('DROP INDEX IDX_C42F778459BB1592 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784F8697D13 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784A76ED395 ON report');
        $this->addSql('ALTER TABLE report ADD comment_id INT NOT NULL, ADD user_id INT NOT NULL, ADD reason_id INT NOT NULL, DROP comment, DROP user, DROP reason');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F778459BB1592 FOREIGN KEY (reason_id) REFERENCES report_reason (id)');
        $this->addSql('CREATE INDEX IDX_C42F778459BB1592 ON report (reason_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784F8697D13 ON report (comment_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784A76ED395 ON report (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784F8697D13');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A76ED395');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F778459BB1592');
        $this->addSql('DROP INDEX IDX_C42F7784F8697D13 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784A76ED395 ON report');
        $this->addSql('DROP INDEX IDX_C42F778459BB1592 ON report');
        $this->addSql('ALTER TABLE report ADD comment INT NOT NULL, ADD user INT NOT NULL, ADD reason INT NOT NULL, DROP comment_id, DROP user_id, DROP reason_id');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77849D86650F FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784D6DE06A6 FOREIGN KEY (comment) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F3D025E7 FOREIGN KEY (reason) REFERENCES report_reason (id)');
        $this->addSql('CREATE INDEX IDX_C42F7784F8697D13 ON report (comment)');
        $this->addSql('CREATE INDEX IDX_C42F7784A76ED395 ON report (user)');
        $this->addSql('CREATE INDEX IDX_C42F778459BB1592 ON report (reason)');
    }
}
