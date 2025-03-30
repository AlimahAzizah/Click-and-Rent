<?php
class CreateUsersTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS utilisateurs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(50) NOT NULL,
                prenom VARCHAR(50) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                mot_de_passe TEXT NOT NULL,
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