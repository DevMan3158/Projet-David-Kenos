<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907085338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, chocolaterie_id INT NOT NULL, contenu LONGTEXT NOT NULL, image_actu VARCHAR(255) DEFAULT NULL, image_actu_alt VARCHAR(255) DEFAULT NULL, crated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_54928197B81041DB (chocolaterie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197B81041DB FOREIGN KEY (chocolaterie_id) REFERENCES chocolaterie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197B81041DB');
        $this->addSql('DROP TABLE actualite');
    }
}
