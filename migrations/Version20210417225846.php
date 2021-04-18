<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417225846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE template_image (template_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_F6EBD7905DA0FB8 (template_id), INDEX IDX_F6EBD7903DA5256D (image_id), PRIMARY KEY(template_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE template_image ADD CONSTRAINT FK_F6EBD7905DA0FB8 FOREIGN KEY (template_id) REFERENCES fourtheme_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE template_image ADD CONSTRAINT FK_F6EBD7903DA5256D FOREIGN KEY (image_id) REFERENCES fourtheme_Image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fourtheme_image DROP FOREIGN KEY FK_35AD68875DA0FB8');
        $this->addSql('DROP INDEX IDX_35AD68875DA0FB8 ON fourtheme_image');
        $this->addSql('ALTER TABLE fourtheme_image DROP template_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE template_image');
        $this->addSql('ALTER TABLE fourtheme_Image ADD template_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fourtheme_Image ADD CONSTRAINT FK_35AD68875DA0FB8 FOREIGN KEY (template_id) REFERENCES fourtheme_template (id)');
        $this->addSql('CREATE INDEX IDX_35AD68875DA0FB8 ON fourtheme_Image (template_id)');
    }
}
