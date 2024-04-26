<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426092713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, team_blue_id INT DEFAULT NULL, team_red_id INT DEFAULT NULL, team_win_id INT DEFAULT NULL, team_blue_score INT NOT NULL, team_red_score INT NOT NULL, date_game DATE NOT NULL, INDEX IDX_232B318CA5C04808 (team_blue_id), INDEX IDX_232B318CFDA5CEFB (team_red_id), INDEX IDX_232B318C725522D (team_win_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, nick_name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, victory INT NOT NULL, defeat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_composition (id INT AUTO_INCREMENT NOT NULL, id_player_id INT DEFAULT NULL, id_team_id INT DEFAULT NULL, INDEX IDX_E74FAC0A19D349F8 (id_player_id), INDEX IDX_E74FAC0AF7F171DE (id_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA5C04808 FOREIGN KEY (team_blue_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CFDA5CEFB FOREIGN KEY (team_red_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C725522D FOREIGN KEY (team_win_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_composition ADD CONSTRAINT FK_E74FAC0A19D349F8 FOREIGN KEY (id_player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE team_composition ADD CONSTRAINT FK_E74FAC0AF7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id)');
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
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_composition');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
