<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905152739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE datum.hashes (
                id INT AUTO_INCREMENT NOT NULL,
                block_number INT NOT NULL,
                input_string varchar(100) NOT NULL,
                key_founded varchar(100) NOT NULL,
                generated_hash varchar(100) NOT NULL,
                tries INT NOT NULL,
                batch DATETIME NOT NULL,
                CONSTRAINT hashes_PK PRIMARY KEY (id)
            )
            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_0900_ai_ci;
        ');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
