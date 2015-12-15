<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151127214118 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, created_by INT NOT NULL, name VARCHAR(255) NOT NULL, intro LONGTEXT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C0155143DE12AB56 (created_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, created_by INT NOT NULL, name VARCHAR(255) NOT NULL, intro LONGTEXT NOT NULL, content LONGTEXT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, create_at DATETIME NOT NULL, INDEX IDX_3BAE0AA7DE12AB56 (created_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_has_blog (event_id INT NOT NULL, blog_id INT NOT NULL, INDEX IDX_DBA563CC71F7E88B (event_id), INDEX IDX_DBA563CCDAE07E97 (blog_id), PRIMARY KEY(event_id, blog_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event_has_blog ADD CONSTRAINT FK_DBA563CC71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_has_blog ADD CONSTRAINT FK_DBA563CCDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_has_blog DROP FOREIGN KEY FK_DBA563CCDAE07E97');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143DE12AB56');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7DE12AB56');
        $this->addSql('ALTER TABLE event_has_blog DROP FOREIGN KEY FK_DBA563CC71F7E88B');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_has_blog');
    }
}
