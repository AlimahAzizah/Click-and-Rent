<?php
class CreatePretsTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS prets (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT,
                materiel_id INT,
                start_date DATE NOT NULL,
                end_date DATE NOT NULL,
                status ENUM('pending', 'accepted', 'refused') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                modified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(user_id),
                FOREIGN KEY (materiel_id) REFERENCES materiels(id)
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE interactions");
    }  
}
?>