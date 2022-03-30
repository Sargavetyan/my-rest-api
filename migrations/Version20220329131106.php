<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329131106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts DROP FOREIGN KEY FK_CAC89EAC296CD8AE');
        $this->addSql('DROP INDEX IDX_CAC89EAC296CD8AE ON accounts');
        $this->addSql('ALTER TABLE accounts CHANGE team_id teamId INT NOT NULL');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EACD8528F51 FOREIGN KEY (teamId) REFERENCES teams (id)');
        $this->addSql('CREATE INDEX IDX_CAC89EACD8528F51 ON accounts (teamId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts DROP FOREIGN KEY FK_CAC89EACD8528F51');
        $this->addSql('DROP INDEX IDX_CAC89EACD8528F51 ON accounts');
        $this->addSql('ALTER TABLE accounts CHANGE teamId team_id INT NOT NULL');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EAC296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('CREATE INDEX IDX_CAC89EAC296CD8AE ON accounts (team_id)');
    }
}
