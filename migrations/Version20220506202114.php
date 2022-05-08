<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506202114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accreditation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE age_section (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, code VARCHAR(10) NOT NULL, color VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_E30B670D77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, default_value_is_visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category_role (event_category_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_F8AB4081B9CF4E62 (event_category_id), INDEX IDX_F8AB4081D60322AC (role_id), PRIMARY KEY(event_category_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category_accreditation (event_category_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_DB34B988B9CF4E62 (event_category_id), INDEX IDX_DB34B988D60322AC (role_id), PRIMARY KEY(event_category_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, age_section_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(10) NOT NULL, feminine_name VARCHAR(100) DEFAULT NULL, icon VARCHAR(50) DEFAULT NULL, INDEX IDX_57698A6AD3F77268 (age_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_accreditation (role_id INT NOT NULL, accreditation_id INT NOT NULL, INDEX IDX_B408184BD60322AC (role_id), INDEX IDX_B408184BA0822E24 (accreditation_id), PRIMARY KEY(role_id, accreditation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scope (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, structure_id INT DEFAULT NULL, role_id INT DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_AF55D3A76ED395 (user_id), INDEX IDX_AF55D32534008B (structure_id), INDEX IDX_AF55D3D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, parent_structure_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(10) NOT NULL, INDEX IDX_6F0137EA755A5DA5 (parent_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(96) NOT NULL, email VARCHAR(200) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, genre VARCHAR(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649D17F50A6 (uuid), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_category_role ADD CONSTRAINT FK_F8AB4081B9CF4E62 FOREIGN KEY (event_category_id) REFERENCES event_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category_role ADD CONSTRAINT FK_F8AB4081D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category_accreditation ADD CONSTRAINT FK_DB34B988B9CF4E62 FOREIGN KEY (event_category_id) REFERENCES event_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category_accreditation ADD CONSTRAINT FK_DB34B988D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AD3F77268 FOREIGN KEY (age_section_id) REFERENCES age_section (id)');
        $this->addSql('ALTER TABLE role_accreditation ADD CONSTRAINT FK_B408184BD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_accreditation ADD CONSTRAINT FK_B408184BA0822E24 FOREIGN KEY (accreditation_id) REFERENCES accreditation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scope ADD CONSTRAINT FK_AF55D3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE scope ADD CONSTRAINT FK_AF55D32534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE scope ADD CONSTRAINT FK_AF55D3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EA755A5DA5 FOREIGN KEY (parent_structure_id) REFERENCES structure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role_accreditation DROP FOREIGN KEY FK_B408184BA0822E24');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AD3F77268');
        $this->addSql('ALTER TABLE event_category_role DROP FOREIGN KEY FK_F8AB4081B9CF4E62');
        $this->addSql('ALTER TABLE event_category_accreditation DROP FOREIGN KEY FK_DB34B988B9CF4E62');
        $this->addSql('ALTER TABLE event_category_role DROP FOREIGN KEY FK_F8AB4081D60322AC');
        $this->addSql('ALTER TABLE event_category_accreditation DROP FOREIGN KEY FK_DB34B988D60322AC');
        $this->addSql('ALTER TABLE role_accreditation DROP FOREIGN KEY FK_B408184BD60322AC');
        $this->addSql('ALTER TABLE scope DROP FOREIGN KEY FK_AF55D3D60322AC');
        $this->addSql('ALTER TABLE scope DROP FOREIGN KEY FK_AF55D32534008B');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EA755A5DA5');
        $this->addSql('ALTER TABLE scope DROP FOREIGN KEY FK_AF55D3A76ED395');
        $this->addSql('DROP TABLE accreditation');
        $this->addSql('DROP TABLE age_section');
        $this->addSql('DROP TABLE event_category');
        $this->addSql('DROP TABLE event_category_role');
        $this->addSql('DROP TABLE event_category_accreditation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_accreditation');
        $this->addSql('DROP TABLE scope');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE `user`');
    }
}
