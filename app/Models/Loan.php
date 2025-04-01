<?php
require_once 'Database.php';
require_once 'Material.php';

class Loan {
    private $db;
    
    // Attributs corresponding to the Loan Table
    private $id;
    private $id_utilisateur;
    private $id_materiel;
    private $date_debut;
    private $date_fin;
    private $statut; // 'en_attente', 'accepte', 'refuse', 'en_cours', 'retourne', 'termine'
    
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
    
    public function getIdUtilisateur() {
        return $this->id_utilisateur;
    }
    
    public function setIdUtilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }
    
    public function getIdMateriel() {
        return $this->id_materiel;
    }
    
    public function setIdMateriel($id_materiel) {
        $this->id_materiel = $id_materiel;
    }
    
    public function getDateDebut() {
        return $this->date_debut;
    }
    
    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
    }
    
    public function getDateFin() {
        return $this->date_fin;
    }
    
    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }
    
    public function getStatut() {
        return $this->statut;
    }
    
    public function setStatut($statut) {
        $this->statut = $statut;
    }
    
    // CRUD Methods
    
    // Create a new loan
    public function create($data) {
        try {
            // Check if the material exists and is available
            $material = new Material();
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                INSERT INTO prets 
                (id_utilisateur, id_materiel, date_debut, date_fin, statut)
                VALUES (:user, :material, :start, :end, 'en_attente')
            ");
            
            $stmt->execute([
                ':user' => $data['id_utilisateur'],
                ':material' => $data['id_materiel'],
                ':start' => $data['date_debut'],
                ':end' => $data['date_fin']
            ]);
            
            // Mark the material as unavailable if the loan is accepted
            if($statut === 'accepte') {
                $material->markAsUnavailable();
            }
            
            return $this->db->lastInsertId();
        } catch(PDOException $e) {
            echo "Erreur de création de prêt: " . $e->getMessage();
            return false;
        }
    }
    
    // Read a loan by id
    public function readById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM prets WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $loanData = $stmt->fetch();
            if($loanData) {
                $this->id = $loanData['id'];
                $this->id_utilisateur = $loanData['id_utilisateur'];
                $this->id_materiel = $loanData['id_materiel'];
                $this->date_debut = $loanData['date_debut'];
                $this->date_fin = $loanData['date_fin'];
                $this->statut = $loanData['statut'];
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Erreur de lecture de prêt: " . $e->getMessage();
            return false;
        }
    }
    
    // Read all loans by user id
    public function readAllByUserId($id_utilisateur) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM prets WHERE id_utilisateur = :id_utilisateur");
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "Erreur de lecture des prêts de l'utilisateur: " . $e->getMessage();
            return [];
        }
    }
    
    // Read all pending loans by material id 
    public function readAllPending() {
        try {
            $stmt = $this->db->query("SELECT * FROM prets WHERE statut = 'en_attente'");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "Erreur de lecture des prêts en attente: " . $e->getMessage();
            return [];
        }
    }
    
    // Special Methods
    
    // Validate a loan 
    public function approve() {
        try {
            if($this->statut !== 'en_attente') {
                return false; // Only pending loans can be approved
            }
            
            // Mark the material as unavailable
            $material = new Material();
            if($material->readById($this->id_materiel)) {
                $material->markAsUnavailable();
            }
            
            $this->statut = 'accepte';
            return $this->update();
        } catch(Exception $e) {
            echo "Erreur lors de l'approbation du prêt: " . $e->getMessage();
            return false;
        }
    }
    
    // Reject a loan
    public function reject() {
        if($this->statut !== 'en_attente') {
            return false; // Only pending loans can be rejected
        }
        
        $this->statut = 'refuse';
        return $this->update();
    }
    
    // Mark a loan as active
    public function markAsActive() {
        if($this->statut !== 'accepte') {
            return false; // Only accepted loans can be marked as active
        }
        
        $this->statut = 'en_cours';
        return $this->update();
    }
    
    // Mark a loan as returned (by the user)
    public function markAsReturned() {
        if($this->statut !== 'en_cours') {
            return false; // Only active loans can be marked as returned
        }
        
        $this->statut = 'retourne';
        return $this->update();
    }
    
    // Confirm a returned loan (by the admin)
    public function confirmReturn() {
        if($this->statut !== 'retourne') {
            return false; // Only returned loans can be confirmed
        }
        
        // Mark the material as available
        $material = new Material();
        if($material->readById($this->id_materiel)) {
            $material->markAsAvailable();
        }
        
        $this->statut = 'termine';
        return $this->update();
    }
    
    // Update a loan 
    private function update() {
        try {
            $stmt = $this->db->prepare("
                UPDATE prets 
                SET id_utilisateur = :id_utilisateur, id_materiel = :id_materiel, 
                    date_debut = :date_debut, date_fin = :date_fin, statut = :statut 
                WHERE id = :id
            ");
            
            $stmt->bindParam(':id_utilisateur', $this->id_utilisateur);
            $stmt->bindParam(':id_materiel', $this->id_materiel);
            $stmt->bindParam(':date_debut', $this->date_debut);
            $stmt->bindParam(':date_fin', $this->date_fin);
            $stmt->bindParam(':statut', $this->statut);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Erreur de mise à jour de prêt: " . $e->getMessage();
            return false;
        }
    }
    
    // Check if a material is available for the given dates
    public static function isMaterialAvailableForDates($id_materiel, $date_debut, $date_fin) {
        try {
            $db = Database::getInstance()->getConnection();
            
            $stmt = $db->prepare("
                SELECT COUNT(*) FROM prets 
                WHERE id_materiel = :id_materiel 
                AND statut IN ('accepte', 'en_cours') 
                AND NOT (date_fin < :date_debut OR date_debut > :date_fin)
            ");
            
            $stmt->bindParam(':id_materiel', $id_materiel);
            $stmt->bindParam(':date_debut', $date_debut);
            $stmt->bindParam(':date_fin', $date_fin);
            $stmt->execute();
            
            return $stmt->fetchColumn() == 0;
        } catch(PDOException $e) {
            echo "Erreur lors de la vérification de disponibilité: " . $e->getMessage();
            return false;
        }
    }
}
?>
