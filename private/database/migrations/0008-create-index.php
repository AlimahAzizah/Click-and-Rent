<?php
class CreateIndex {
    public function up($connection) {
        $connection->exec("
            CREATE INDEX idx_interactions_date ON interactions(interaction_date);
        ");
    }

    public function down($connection) {
        $connection->exec("
            DROP INDEX idx_interactions_date;
        ");
    }
}
?>