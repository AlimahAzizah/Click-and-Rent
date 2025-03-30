<?php
class CreateMaterielsTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS materiels (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                description TEXT,
                etat VARCHAR(50) NOT NULL,
                photo VARCHAR(255),
                disponibilite BOOLEAN DEFAULT TRUE,
                date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE materiels;");
    }  
}
?>