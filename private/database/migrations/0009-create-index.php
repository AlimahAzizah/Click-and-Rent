<?php
class CreateIndex {
    public function up($connection) {
        $connection->exec("
            CREATE INDEX idx_metrics_relationship ON behavioral_metrics(relationship_id);
        ");
    }

    public function down($connection) {
        $connection->exec("
            DROP INDEX idx_metrics_relationship;
        ");
    }
}
?>