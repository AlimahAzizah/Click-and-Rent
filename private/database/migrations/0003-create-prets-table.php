<?php
class CreatePretsTable {
    public function up($connection) {
        $connection->exec("
            CREATE TABLE IF NOT EXISTS prets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                id_utilisateur INT NOT NULL,
                id_materiel INT NOT NULL,
                date_debut DATE NOT NULL,
                date_fin DATE NOT NULL,
                statut ENUM('en_attente', 'accepte', 'refuse', 'en_cours', 'retourne', 'termine') DEFAULT 'en_attente',
                date_demande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE,
                FOREIGN KEY (id_materiel) REFERENCES materiels(id) ON DELETE CASCADE
            );
        ");
    }

    public function down($connection) {
        $connection->exec("DROP TABLE prets;");
    }  
}
?>