<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190224183046 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cargo (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, manager_id INT DEFAULT NULL, container VARCHAR(50) DEFAULT NULL, date_arrival DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_3BEE577119EB6921 (client_id), INDEX IDX_3BEE5771783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE577119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE cargo ADD CONSTRAINT FK_3BEE5771783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cargo');
    }
}
