<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422072537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fourtheme_category ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fourtheme_category ADD CONSTRAINT FK_45E7A800F675F31B FOREIGN KEY (author_id) REFERENCES fourtheme_user (id)');
        $this->addSql('CREATE INDEX IDX_45E7A800F675F31B ON fourtheme_category (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fourtheme_category DROP FOREIGN KEY FK_45E7A800F675F31B');
        $this->addSql('DROP INDEX IDX_45E7A800F675F31B ON fourtheme_category');
        $this->addSql('ALTER TABLE fourtheme_category DROP author_id');
    }
}
