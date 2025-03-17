<?php
class CreateIndex {
    public function up($connection) {
        $connection->exec("
            CREATE INDEX idx_relationships_dyad ON relationships(person_a, person_b);
        ");
    }

    public function down($connection) {
        $connection->exec("
            DROP INDEX idx_relationships_dyad;
        ");
    }
}
?>