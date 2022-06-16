<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519090434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events_structure (events_id INT NOT NULL, structure_id INT NOT NULL, INDEX IDX_F6F552C89D6A1065 (events_id), INDEX IDX_F6F552C82534008B (structure_id), PRIMARY KEY(events_id, structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events_structure ADD CONSTRAINT FK_F6F552C89D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_structure ADD CONSTRAINT FK_F6F552C82534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE events_structure');
    }
}
