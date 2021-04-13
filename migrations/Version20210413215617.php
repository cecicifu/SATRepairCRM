<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413215617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , name VARCHAR(30) NOT NULL, description VARCHAR(100) DEFAULT NULL, modified DATETIME NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE customer (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , fullname VARCHAR(70) NOT NULL, address VARCHAR(70) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, email VARCHAR(70) DEFAULT NULL, zip_code INTEGER DEFAULT NULL, phone INTEGER NOT NULL, modified DATETIME NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , name VARCHAR(50) NOT NULL, amount INTEGER NOT NULL, price DOUBLE PRECISION DEFAULT NULL, modified DATETIME NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE repair (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , customer_id CHAR(36) DEFAULT NULL --(DC2Type:uuid)
        , category_id CHAR(36) DEFAULT NULL --(DC2Type:uuid)
        , status_id CHAR(36) DEFAULT NULL --(DC2Type:uuid)
        , code VARCHAR(16) NOT NULL, imei INTEGER DEFAULT NULL, pattern VARCHAR(20) DEFAULT NULL, fault VARCHAR(85) NOT NULL, colour VARCHAR(50) DEFAULT NULL, private_comment VARCHAR(200) DEFAULT NULL, public_comment VARCHAR(200) DEFAULT NULL, labour_price INTEGER DEFAULT NULL, tax INTEGER DEFAULT NULL, visible INTEGER NOT NULL, modified DATETIME NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8EE4342177153098 ON repair (code)');
        $this->addSql('CREATE INDEX IDX_8EE434219395C3F3 ON repair (customer_id)');
        $this->addSql('CREATE INDEX IDX_8EE4342112469DE2 ON repair (category_id)');
        $this->addSql('CREATE INDEX IDX_8EE434216BF700BD ON repair (status_id)');
        $this->addSql('CREATE TABLE repair_products (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , repair CHAR(36) NOT NULL --(DC2Type:uuid)
        , product CHAR(36) NOT NULL --(DC2Type:uuid)
        , quantity INTEGER NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA2223F18EE43421 ON repair_products (repair)');
        $this->addSql('CREATE INDEX IDX_DA2223F1D34A04AD ON repair_products (product)');
        $this->addSql('CREATE TABLE status (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , name VARCHAR(25) NOT NULL, colour VARCHAR(50) DEFAULT NULL, modified DATETIME NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B00651C5E237E06 ON status (name)');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , username VARCHAR(15) NOT NULL, email VARCHAR(70) DEFAULT NULL, password VARCHAR(100) NOT NULL, last_session DATETIME DEFAULT NULL, modified DATETIME NOT NULL, created DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE repair_products');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE user');
    }
}
