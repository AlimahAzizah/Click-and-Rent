<?php
class CreateUsersTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS utilisateurs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                mot_de_passe VARCHAR(255) NOT NULL,
                role ENUM('utilisateur', 'admin') DEFAULT 'utilisateur',
                date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE utilisateurs;");
    }  
}
?>