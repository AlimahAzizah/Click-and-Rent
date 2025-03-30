<?php
require_once 'Database.php';

class User {
    private $db;
    
    // Attributs corresponding to the User Table
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $motDePasse;
    private $role; // user or admin
    
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
    
    public function getPrenom() {
        return $this->prenom;
    }
    
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getMotDePasse() {
        return $this->motDePasse;
    }
    
    public function setMotDePasse($motDePasse) {
        // Hachage du mot de passe pour la sécurité
        $this->motDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);
    }
    
    public function getRole() {
        return $this->role;
    }
    
    public function setRole($role) {
        $this->role = $role;
    }
    
    // CRUD methods
    
    // Create a new user
    public function create($nom, $prenom, $email, $motDePasse, $role = 'utilisateur') {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) 
                VALUES (:nom, :prenom, :email, :motDePasse, :role)
            ");
            
            $hashedPassword = password_hash($motDePasse, PASSWORD_DEFAULT);
            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':motDePasse', $hashedPassword);
            $stmt->bindParam(':role', $role);
            
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch(PDOException $e) {
            echo "Erreur de création d'utilisateur: " . $e->getMessage();
            return false;
        }
    }
    
    // Read a user by id
    public function readById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $userData = $stmt->fetch();
            if($userData) {
                $this->id = $userData['id'];
                $this->nom = $userData['nom'];
                $this->prenom = $userData['prenom'];
                $this->email = $userData['email'];
                $this->motDePasse = $userData['mot_de_passe'];
                $this->role = $userData['role'];
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Erreur de lecture d'utilisateur: " . $e->getMessage();
            return false;
        }
    }
    
    // Read a user by email
    public function readByEmail($email) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $userData = $stmt->fetch();
            if($userData) {
                $this->id = $userData['id'];
                $this->nom = $userData['nom'];
                $this->prenom = $userData['prenom'];
                $this->email = $userData['email'];
                $this->motDePasse = $userData['mot_de_passe'];
                $this->role = $userData['role'];
                return true;
            }
            return false;
        } catch(PDOException $e) {
            echo "Erreur de lecture d'utilisateur: " . $e->getMessage();
            return false;
        }
    }
    
    // Read all users
    public function readAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM utilisateurs");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            echo "Erreur de lecture des utilisateurs: " . $e->getMessage();
            return [];
        }
    }
    
    // Update a user
    public function update() {
        try {
            $stmt = $this->db->prepare("
                UPDATE utilisateurs 
                SET nom = :nom, prenom = :prenom, email = :email, role = :role 
                WHERE id = :id
            ");
            
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':role', $this->role);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Erreur de mise à jour d'utilisateur: " . $e->getMessage();
            return false;
        }
    }
    
    // Special methods
    
    // Check the login credentials
    public function login($email, $password) {
        if($this->readByEmail($email)) {
            return password_verify($password, $this->motDePasse);
        }
        return false;
    }
    
    // Check if the user is an admin
    public function isAdmin() {
        return $this->role === 'admin';
    }
}
?>
