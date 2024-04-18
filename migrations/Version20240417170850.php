<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417170850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD state VARCHAR(255) DEFAULT \'waiting\' NOT NULL, DROP investors_equity, CHANGE risk_analysis risk_analysis TEXT DEFAULT NULL, CHANGE market_strategy market_strategy TEXT DEFAULT NULL, CHANGE exit_strategy exit_strategy TEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX uc_name ON projects (NAME)');
        $this->addSql('ALTER TABLE projects RENAME INDEX fk_category TO projects_ibfk_1');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX uc_name ON projects');
        $this->addSql('ALTER TABLE projects ADD investors_equity TEXT DEFAULT NULL, DROP state, CHANGE risk_analysis risk_analysis VARCHAR(1000) DEFAULT NULL, CHANGE market_strategy market_strategy VARCHAR(1000) DEFAULT NULL, CHANGE exit_strategy exit_strategy VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects RENAME INDEX projects_ibfk_1 TO fk_category');
    }
}
