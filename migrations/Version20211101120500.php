<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101120500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD username_canonical VARCHAR(120) NOT NULL, ADD email VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD gender VARCHAR(20) NOT NULL, ADD birthdate DATETIME DEFAULT NULL, ADD enabled TINYINT(1) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD phone VARCHAR(255) NOT NULL, ADD facebook_id VARCHAR(255) DEFAULT NULL, ADD confirmation_token VARCHAR(255) DEFAULT NULL, CHANGE username username VARCHAR(120) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D64992FC23A8 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649A0D96FBF ON user');
        $this->addSql('ALTER TABLE user DROP username_canonical, DROP email, DROP email_canonical, DROP gender, DROP birthdate, DROP enabled, DROP last_login, DROP password_requested_at, DROP phone, DROP facebook_id, DROP confirmation_token, CHANGE username username VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
