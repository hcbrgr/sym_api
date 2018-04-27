<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180427071227 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE call_sheet DROP FOREIGN KEY FK_E5D60D5A3E5F2F7B');
        $this->addSql('ALTER TABLE call_sheet DROP FOREIGN KEY FK_E5D60D5A9D86650F');
        $this->addSql('DROP INDEX IDX_E5D60D5A9D86650F ON call_sheet');
        $this->addSql('DROP INDEX IDX_E5D60D5A3E5F2F7B ON call_sheet');
        $this->addSql('ALTER TABLE call_sheet ADD user_id INT NOT NULL, ADD event_id INT NOT NULL, DROP user_id_id, DROP event_id_id');
        $this->addSql('ALTER TABLE call_sheet ADD CONSTRAINT FK_E5D60D5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE call_sheet ADD CONSTRAINT FK_E5D60D5A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_E5D60D5AA76ED395 ON call_sheet (user_id)');
        $this->addSql('CREATE INDEX IDX_E5D60D5A71F7E88B ON call_sheet (event_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE call_sheet DROP FOREIGN KEY FK_E5D60D5AA76ED395');
        $this->addSql('ALTER TABLE call_sheet DROP FOREIGN KEY FK_E5D60D5A71F7E88B');
        $this->addSql('DROP INDEX IDX_E5D60D5AA76ED395 ON call_sheet');
        $this->addSql('DROP INDEX IDX_E5D60D5A71F7E88B ON call_sheet');
        $this->addSql('ALTER TABLE call_sheet ADD user_id_id INT NOT NULL, ADD event_id_id INT NOT NULL, DROP user_id, DROP event_id');
        $this->addSql('ALTER TABLE call_sheet ADD CONSTRAINT FK_E5D60D5A3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE call_sheet ADD CONSTRAINT FK_E5D60D5A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E5D60D5A9D86650F ON call_sheet (user_id_id)');
        $this->addSql('CREATE INDEX IDX_E5D60D5A3E5F2F7B ON call_sheet (event_id_id)');
    }
}
