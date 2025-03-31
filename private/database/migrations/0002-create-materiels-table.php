<?php
class CreateMaterielsTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS materiels (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                description TEXT,
                categorie VARCHAR(50) NOT NULL,
                etat VARCHAR(50) NOT NULL,
                photo BLOB,
                disponibilite BOOLEAN DEFAULT TRUE,
                date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE materiels;");
    }  
}
?>