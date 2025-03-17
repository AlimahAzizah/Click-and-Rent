<?php
class CreateUsersTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS users (
                user_id INT PRIMARY KEY AUTO_INCREMENT,
                uid BINARY(16) UNIQUE DEFAULT (UUID_TO_BIN(UUID())),
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user',
                username VARCHAR(50) UNIQUE NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE users");
    }  
}
?>