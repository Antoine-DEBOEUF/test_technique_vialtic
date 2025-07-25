<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725060632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE driver_driving_license (driver_id INT NOT NULL, driving_license_id INT NOT NULL, INDEX IDX_A6151E19C3423909 (driver_id), INDEX IDX_A6151E193FFBF177 (driving_license_id), PRIMARY KEY(driver_id, driving_license_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE driver_driving_license ADD CONSTRAINT FK_A6151E19C3423909 FOREIGN KEY (driver_id) REFERENCES driver (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driver_driving_license ADD CONSTRAINT FK_A6151E193FFBF177 FOREIGN KEY (driving_license_id) REFERENCES driving_license (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE driver DROP driving_license');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE driver_driving_license DROP FOREIGN KEY FK_A6151E19C3423909');
        $this->addSql('ALTER TABLE driver_driving_license DROP FOREIGN KEY FK_A6151E193FFBF177');
        $this->addSql('DROP TABLE driver_driving_license');
        $this->addSql('ALTER TABLE driver ADD driving_license VARCHAR(255) NOT NULL');
    }
}
