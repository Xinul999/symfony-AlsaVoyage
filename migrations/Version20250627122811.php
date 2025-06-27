<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250627122811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, auteur_id, post_id, date_heure_creation, contenu, signale FROM commentaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commentaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER NOT NULL, post_id INTEGER NOT NULL, date_heure_creation DATETIME NOT NULL, contenu CLOB NOT NULL, signale BOOLEAN NOT NULL, CONSTRAINT FK_67F068BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_67F068BC4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO commentaire (id, auteur_id, post_id, date_heure_creation, contenu, signale) SELECT id, auteur_id, post_id, date_heure_creation, contenu, signale FROM __temp__commentaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__commentaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_67F068BC4B89032C ON commentaire (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_67F068BC60BB6FE6 ON commentaire (auteur_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, auteur_id, post_id, date_heure_creation, contenu, signale FROM commentaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commentaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER DEFAULT NULL, post_id INTEGER NOT NULL, date_heure_creation DATETIME NOT NULL, contenu CLOB NOT NULL, signale BOOLEAN NOT NULL, CONSTRAINT FK_67F068BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_67F068BC4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO commentaire (id, auteur_id, post_id, date_heure_creation, contenu, signale) SELECT id, auteur_id, post_id, date_heure_creation, contenu, signale FROM __temp__commentaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__commentaire
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_67F068BC60BB6FE6 ON commentaire (auteur_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_67F068BC4B89032C ON commentaire (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, roles, password, is_verified FROM "user"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(255) NOT NULL,roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO "user" (id, username, email, roles, password, is_verified) SELECT id, username, email, roles, password, is_verified FROM __temp__user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__user
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)
        SQL);
    }
}
