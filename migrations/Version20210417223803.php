<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417223803 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fourtheme_Image (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, template_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, image_size INT NOT NULL, mime_type VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, dimensions LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_35AD6887F675F31B (author_id), INDEX IDX_35AD68875DA0FB8 (template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_category (image_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_89BC97693DA5256D (image_id), INDEX IDX_89BC976912469DE2 (category_id), PRIMARY KEY(image_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fourtheme_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fourtheme_template (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D4CBAE42F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template_category (template_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_591A29B25DA0FB8 (template_id), INDEX IDX_591A29B212469DE2 (category_id), PRIMARY KEY(template_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fourtheme_Image ADD CONSTRAINT FK_35AD6887F675F31B FOREIGN KEY (author_id) REFERENCES fourtheme_user (id)');
        $this->addSql('ALTER TABLE fourtheme_Image ADD CONSTRAINT FK_35AD68875DA0FB8 FOREIGN KEY (template_id) REFERENCES fourtheme_template (id)');
        $this->addSql('ALTER TABLE image_category ADD CONSTRAINT FK_89BC97693DA5256D FOREIGN KEY (image_id) REFERENCES fourtheme_Image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_category ADD CONSTRAINT FK_89BC976912469DE2 FOREIGN KEY (category_id) REFERENCES fourtheme_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fourtheme_template ADD CONSTRAINT FK_D4CBAE42F675F31B FOREIGN KEY (author_id) REFERENCES fourtheme_user (id)');
        $this->addSql('ALTER TABLE template_category ADD CONSTRAINT FK_591A29B25DA0FB8 FOREIGN KEY (template_id) REFERENCES fourtheme_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE template_category ADD CONSTRAINT FK_591A29B212469DE2 FOREIGN KEY (category_id) REFERENCES fourtheme_category (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE image');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_category DROP FOREIGN KEY FK_89BC97693DA5256D');
        $this->addSql('ALTER TABLE image_category DROP FOREIGN KEY FK_89BC976912469DE2');
        $this->addSql('ALTER TABLE template_category DROP FOREIGN KEY FK_591A29B212469DE2');
        $this->addSql('ALTER TABLE fourtheme_Image DROP FOREIGN KEY FK_35AD68875DA0FB8');
        $this->addSql('ALTER TABLE template_category DROP FOREIGN KEY FK_591A29B25DA0FB8');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, image_size INT NOT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, original_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dimensions LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:simple_array)\', INDEX IDX_C53D045FF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF675F31B FOREIGN KEY (author_id) REFERENCES fourtheme_user (id)');
        $this->addSql('DROP TABLE fourtheme_Image');
        $this->addSql('DROP TABLE image_category');
        $this->addSql('DROP TABLE fourtheme_category');
        $this->addSql('DROP TABLE fourtheme_template');
        $this->addSql('DROP TABLE template_category');
    }
}
