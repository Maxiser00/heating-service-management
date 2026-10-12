<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425115854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intervention_stock (intervention_id INT NOT NULL, stock_id INT NOT NULL, PRIMARY KEY(intervention_id, stock_id))');
        $this->addSql('CREATE INDEX IDX_3E534AE48EAE3863 ON intervention_stock (intervention_id)');
        $this->addSql('CREATE INDEX IDX_3E534AE4DCD6110 ON intervention_stock (stock_id)');
        $this->addSql('CREATE TABLE user_skill (utilisateur_id INT NOT NULL, skill_id INT NOT NULL, PRIMARY KEY(utilisateur_id, skill_id))');
        $this->addSql('CREATE INDEX IDX_BCFF1F2FFB88E14F ON user_skill (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_BCFF1F2F5585C142 ON user_skill (skill_id)');
        $this->addSql('ALTER TABLE intervention_stock ADD CONSTRAINT FK_3E534AE48EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE intervention_stock ADD CONSTRAINT FK_3E534AE4DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE intervention ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE intervention ADD fault_id INT NOT NULL');
        $this->addSql('ALTER TABLE intervention ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB24171CD3 FOREIGN KEY (fault_id) REFERENCES fault (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D11814ABA76ED395 ON intervention (user_id)');
        $this->addSql('CREATE INDEX IDX_D11814AB24171CD3 ON intervention (fault_id)');
        $this->addSql('CREATE INDEX IDX_D11814AB545317D1 ON intervention (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE intervention_stock DROP CONSTRAINT FK_3E534AE48EAE3863');
        $this->addSql('ALTER TABLE intervention_stock DROP CONSTRAINT FK_3E534AE4DCD6110');
        $this->addSql('ALTER TABLE user_skill DROP CONSTRAINT FK_BCFF1F2FFB88E14F');
        $this->addSql('ALTER TABLE user_skill DROP CONSTRAINT FK_BCFF1F2F5585C142');
        $this->addSql('DROP TABLE intervention_stock');
        $this->addSql('DROP TABLE user_skill');
        $this->addSql('ALTER TABLE intervention DROP CONSTRAINT FK_D11814ABA76ED395');
        $this->addSql('ALTER TABLE intervention DROP CONSTRAINT FK_D11814AB24171CD3');
        $this->addSql('ALTER TABLE intervention DROP CONSTRAINT FK_D11814AB545317D1');
        $this->addSql('DROP INDEX IDX_D11814ABA76ED395');
        $this->addSql('DROP INDEX IDX_D11814AB24171CD3');
        $this->addSql('DROP INDEX IDX_D11814AB545317D1');
        $this->addSql('ALTER TABLE intervention DROP user_id');
        $this->addSql('ALTER TABLE intervention DROP fault_id');
        $this->addSql('ALTER TABLE intervention DROP vehicle_id');
    }
}
