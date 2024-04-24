<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424075823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, team_blue_id INT DEFAULT NULL, team_red_id INT DEFAULT NULL, team_win_id INT DEFAULT NULL, INDEX IDX_232B318CA5C04808 (team_blue_id), INDEX IDX_232B318CFDA5CEFB (team_red_id), INDEX IDX_232B318C725522D (team_win_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_composition (id INT AUTO_INCREMENT NOT NULL, id_player_id INT DEFAULT NULL, id_team_id INT DEFAULT NULL, INDEX IDX_E74FAC0A19D349F8 (id_player_id), INDEX IDX_E74FAC0AF7F171DE (id_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA5C04808 FOREIGN KEY (team_blue_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CFDA5CEFB FOREIGN KEY (team_red_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C725522D FOREIGN KEY (team_win_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_composition ADD CONSTRAINT FK_E74FAC0A19D349F8 FOREIGN KEY (id_player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE team_composition ADD CONSTRAINT FK_E74FAC0AF7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE player ADD last_name VARCHAR(50) NOT NULL, ADD first_name VARCHAR(50) NOT NULL, ADD nick_name VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA5C04808');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CFDA5CEFB');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C725522D');
        $this->addSql('ALTER TABLE team_composition DROP FOREIGN KEY FK_E74FAC0A19D349F8');
        $this->addSql('ALTER TABLE team_composition DROP FOREIGN KEY FK_E74FAC0AF7F171DE');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_composition');
        $this->addSql('ALTER TABLE player DROP last_name, DROP first_name, DROP nick_name');
    }
}
