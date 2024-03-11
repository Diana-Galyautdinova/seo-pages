<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240311204956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE example_entity_seo_page (id INT AUTO_INCREMENT NOT NULL, seo_page_id INT DEFAULT NULL, additional_field VARCHAR(255) NOT NULL, INDEX IDX_69CA70FA57F59AF (seo_page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_seo_page (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, active TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, seo_title VARCHAR(255) NOT NULL, seo_h1 VARCHAR(255) NOT NULL, seo_keywords VARCHAR(255) DEFAULT NULL, seo_description VARCHAR(255) DEFAULT NULL, seo_text LONGTEXT DEFAULT NULL, filters LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', sort INT DEFAULT 0 NOT NULL, fill_manually TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_E491192B989D9B62 (slug), INDEX IDX_E491192BFE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_seo_page_group (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, slug VARCHAR(100) NOT NULL, name VARCHAR(50) NOT NULL, sort INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE example_entity_seo_page ADD CONSTRAINT FK_69CA70FA57F59AF FOREIGN KEY (seo_page_id) REFERENCES site_seo_page (id)');
        $this->addSql('ALTER TABLE site_seo_page ADD CONSTRAINT FK_E491192BFE54D947 FOREIGN KEY (group_id) REFERENCES site_seo_page_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE example_entity_seo_page DROP FOREIGN KEY FK_69CA70FA57F59AF');
        $this->addSql('ALTER TABLE site_seo_page DROP FOREIGN KEY FK_E491192BFE54D947');
        $this->addSql('DROP TABLE example_entity_seo_page');
        $this->addSql('DROP TABLE site_seo_page');
        $this->addSql('DROP TABLE site_seo_page_group');
    }
}
