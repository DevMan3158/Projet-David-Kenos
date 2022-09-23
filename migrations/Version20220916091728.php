<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916091728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197B81041DB');
        $this->addSql('ALTER TABLE actualite CHANGE chocolaterie_id chocolaterie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197B81041DBB81041DB FOREIGN KEY (chocolaterie_id) REFERENCES chocolaterie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD contenu LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197B81041DBB81041DB');
        $this->addSql('ALTER TABLE actualite CHANGE chocolaterie_id chocolaterie_id INT NOT NULL');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197B81041DB FOREIGN KEY (chocolaterie_id) REFERENCES chocolaterie (id)');
        $this->addSql('ALTER TABLE commentaire DROP contenu LONGTEXT NOT NULL');
    }
}
