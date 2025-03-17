<?php
class CreateMaterielsTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS materiels (
                id INT PRIMARY KEY AUTO_INCREMENT,
                uid BINARY(16) UNIQUE DEFAULT (UUID_TO_BIN(UUID())),
                name VARCHAR(50) NOT NULL,
                description VARCHAR(255) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                picture BLOB NOT NULL,
                state ENUM('new', 'used') DEFAULT 'new',
                availability ENUM('available', 'unavailable') DEFAULT 'available'
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE relationships");
    }  
}
?>