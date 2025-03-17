<?php
class CreateConstraint {
    public function up($connection) {
        $connection->exec("
            ALTER TABLE behavioral_metrics
            ADD CONSTRAINT valid_reciprocity 
            CHECK (emotional_reciprocity_index <= support_balance_ratio);
        ");
    }

    public function down($connection) {
        $connection->exec("
            ALTER TABLE behavioral_metrics DROP CONSTRAINT valid_reciprocity;
        ");
    }
}
?>