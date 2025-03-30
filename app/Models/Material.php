<?php
require_once 'Database.php';

class Material {
    private $db;
    
    // Attributs corresponding to the Material Table
    private $id;
    private $nom;
    private $description;
    private $etat; // 'neuf', 'bon', 'moyen', 'mauvais'
    private $photo;
    private $disponibilite; // true or false
    
    // Constructor
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Getters and Setters
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getEtat() {
        return $this->etat;
    }
    
    public function setEtat($etat) {
        $this->etat = $etat;
    }
    
    public function getPhoto() {
        return $this->photo;
    }
    
    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    
    public function getDisponibilite() {
        return $this->disponibilite;
    }
    
    public function setDisponibilite($disponibilite) {
        $this->disponibilite = $disponibilite;
    }
    
    // CRUD methods
    
    // Create a new material
    public function create($nom, $description, $etat, $photo, $disponibilite = true) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO materiels (nom, description, etat, photo, disponibilite) 
                VALUES (:nom, :description, :etat, :photo, :disponibilite)
            ");
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':etat', $etat);
            $stmt->bindParam(':photo', $photo);
            $stmt->bindParam(':disponibilite', $disponibilite, PDO::PARAM_BOOL);
            
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch(PDOException $e) {
            echo "Erreur de création de matériel: " . $e->getMessage();
            return false;
        }
    }
    
    // Read a material by id
    public function readById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM materiels WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $materialData = $stmt->fetch();
            if($materialData) {
                $this->id = $materialData['id'];
                $this->nom = $materialData['nom'];
                $this->description = $materialData['description'];
                $this->etat = $materialData['etat'];
                $this->photo = $materialData['photo'];
                $this->disponibilite = $materialData['disponibilite'];
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Erreur de lecture de matériel: " . $e->getMessage();
            return false;
        }
    }
    
    // Read all materials
    public function readAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM materiels");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "Erreur de lecture des matériels: " . $e->getMessage();
            return [];
        }
    }
    
    // Read all available materials
    public function readAllAvailable() {
        try {
            $stmt = $this->db->query("SELECT * FROM materiels WHERE disponibilite = TRUE");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "Erreur de lecture des matériels disponibles: " . $e->getMessage();
            return [];
        }
    }
    
    // Update a material
    public function update() {
        try {
            $stmt = $this->db->prepare("
                UPDATE materiels 
                SET nom = :nom, description = :description, etat = :etat, 
                    photo = :photo, disponibilite = :disponibilite 
                WHERE id = :id
            ");
            
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':etat', $this->etat);
            $stmt->bindParam(':photo', $this->photo);
            $stmt->bindParam(':disponibilite', $this->disponibilite, PDO::PARAM_BOOL);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Erreur de mise à jour de matériel: " . $e->getMessage();
            return false;
        }
    }
    
    // Special methods
    
    // Mark a material as available
    public function markAsAvailable() {
        $this->disponibilite = true;
        return $this->update();
    }
    
    // Mark a material as unavailable
    public function markAsUnavailable() {
        $this->disponibilite = false;
        return $this->update();
    }
    
    // Search for materials by name or description
    public function search($query) {
        try {
            $searchTerm = "%$query%";
            $stmt = $this->db->prepare("
                SELECT * FROM materiels 
                WHERE nom LIKE :query OR description LIKE :query
            ");
            $stmt->bindParam(':query', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "Erreur lors de la recherche de matériels: " . $e->getMessage();
            return [];
        }
    }
}
?>
