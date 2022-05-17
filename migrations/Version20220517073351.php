<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517073351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_visible TINYINT(1) NOT NULL, INDEX IDX_5387574A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_role (events_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_3B398E109D6A1065 (events_id), INDEX IDX_3B398E10D60322AC (role_id), PRIMARY KEY(events_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events_user (events_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E1C3D2339D6A1065 (events_id), INDEX IDX_E1C3D233A76ED395 (user_id), PRIMARY KEY(events_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A12469DE2 FOREIGN KEY (category_id) REFERENCES event_category (id)');
        $this->addSql('ALTER TABLE events_role ADD CONSTRAINT FK_3B398E109D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_role ADD CONSTRAINT FK_3B398E10D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_user ADD CONSTRAINT FK_E1C3D2339D6A1065 FOREIGN KEY (events_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE events_user ADD CONSTRAINT FK_E1C3D233A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events_role DROP FOREIGN KEY FK_3B398E109D6A1065');
        $this->addSql('ALTER TABLE events_user DROP FOREIGN KEY FK_E1C3D2339D6A1065');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE events_role');
        $this->addSql('DROP TABLE events_user');
    }
}
