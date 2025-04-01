<?php

require_once __DIR__ . '/../Models/Loan.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Material.php';
require_once __DIR__ . '/../Models/Database.php';

class LoanController {
    private $loanModel;
    private $userModel;
    private $materialModel;

    public function __construct() {
        $this->loanModel = new Loan();
        $this->userModel = new User();
        $this->materialModel = new Material();
    }

    // Check if the user is an admin
    private function isAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        $this->userModel->readById($_SESSION['user_id']);
        return $this->userModel->isAdmin();
    }

    // Check if the user is authenticated and an admin
    private function ensureAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }
    }

    // Check if the user is authenticated
    private function ensureAuthenticated() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
            header('Location: index.php?action=showLogin');
            exit();
        }
    }

    // Function to enhance loan data with user and material information
    private function enhanceLoanData($loans) {
        $enhancedLoans = [];
        
        foreach ($loans as $loan) {
            // Get user information
            $this->userModel->readById($loan['id_utilisateur']);
            
            // Get material information
            $this->materialModel->readById($loan['id_materiel']);
            
            // Enhance loan with additional information
            $enhancedLoan = [
                'id' => $loan['id'],
                'user_nom' => $this->userModel->getNom(),
                'user_prenom' => $this->userModel->getPrenom(),
                'material_nom' => $this->materialModel->getNom(),
                'material_photo' => $this->materialModel->getPhoto(),
                'date_debut' => $loan['date_debut'],
                'date_fin' => $loan['date_fin'],
                'statut' => $loan['statut']
            ];
            
            $enhancedLoans[] = $enhancedLoan;
        }
        
        return $enhancedLoans;
    }







    public function createLoanFromCart() {
        $this->ensureAuthenticated();
        
        // Validate cart existence
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['error'] = "Votre panier est vide";
            header('Location: index.php?action=showPanier');
            exit();
        }

        // Retrieve and validate dates
        $startDate = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
        $endDate = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);
        
        

        // Check material availability
        $unavailableMaterials = [];
        foreach ($_SESSION['cart'] as $materialId) {
            if (!$this->isMaterialAvailable($materialId, $startDate, $endDate)) {
                $unavailableMaterials[] = $materialId;
            }
        }

        if (!empty($unavailableMaterials)) {
            $_SESSION['error'] = "Certains matériels ne sont pas disponibles : " 
                                . implode(', ', $unavailableMaterials);
            header('Location: index.php?action=showPanier');
            exit();
        }

        // Create loans transaction
        try {
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            foreach ($_SESSION['cart'] as $materialId) {
                $loanData = [
                    'id_utilisateur' => $_SESSION['user_id'],
                    'id_materiel' => $materialId,
                    'date_debut' => $startDate,
                    'date_fin' => $endDate,
                    'statut' => 'en_attente'
                ];

                echo $loanData['id_utilisateur'] . " " . $loanData['id_materiel'] . " " . $loanData['date_debut'] . " " . $loanData['date_fin'] . "<br>";

                if ($this->loanModel->create($loanData)) {
                    $this->loanModel->create($loanData);
                } else {
                    throw new PDOException("Erreur lors de la création du prêt pour le matériel $materialId");
                }
            }

            $db->commit();
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Prêt créé avec succès! En attente de confirmation administrateur";
            header('Location: index.php?action=showUserCurrentLoans');
            exit();

        } catch (PDOException $e) {
            $db->rollBack();
            $_SESSION['error'] = "Erreur lors de la création du prêt : " . $e->getMessage();
            header('Location: index.php?action=showPanier');
            exit();
        }
    }

    private function validateDates($start, $end) {
        if (!$start || !$end) return false;
        
        $startDate = DateTime::createFromFormat('Y-m-d', $start);
        $endDate = DateTime::createFromFormat('Y-m-d', $end);
        $today = new DateTime();

        return $startDate && $endDate &&
            $startDate >= $today &&
            $startDate < $endDate;
    }

    private function isMaterialAvailable($materialId, $startDate, $endDate) {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT COUNT(*) 
                FROM prets 
                WHERE id_materiel = :materialId 
                AND statut NOT IN ('rejeté', 'terminé')
                AND (
                    (date_debut <= :endDate AND date_fin >= :startDate)
                )
            ");
            
            $stmt->execute([
                ':materialId' => $materialId,
                ':startDate' => $startDate,
                ':endDate' => $endDate
            ]);

            return $stmt->fetchColumn() === 0;
            
        } catch (PDOException $e) {
            error_log("Availability check error: " . $e->getMessage());
            return false;
        }
    }








    // Admin: Get all loan information
    public function getAllLoans() {
        // Check if user is admin
        $this->ensureAdmin();
        
        // Get all loans from database using PDO directly
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM prets ORDER BY date_debut DESC");
            $loans = $stmt->fetchAll();
            
            // Enhance loans with user and material information
            $enhancedLoans = $this->enhanceLoanData($loans);
            
            // Load view
            require_once __DIR__ . '/../Views/loans/admin-all-loans.php';
            
        } catch(PDOException $e) {
            $_SESSION['error'] = "Erreur de récupération des prêts: " . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    // Admin: Get all active loans
    public function getActiveLoans() {
        // Check if user is admin
        $this->ensureAdmin();
        
        // Get all active loans from database
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT * FROM prets WHERE statut = 'en_cours' ORDER BY date_debut DESC");
            $loans = $stmt->fetchAll();
            
            // Enhance loans with user and material information
            $enhancedLoans = $this->enhanceLoanData($loans);
            
            // Load view
            require_once __DIR__ . '/../Views/loans/admin-active-loans.php';
            
        } catch(PDOException $e) {
            $_SESSION['error'] = "Erreur de récupération des prêts actifs: " . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    // Admin: Get all loans waiting for confirmation or rejection
    public function getPendingLoans() {
        // Check if user is admin
        $this->ensureAdmin();
        
        // Use the model's method to get pending loans
        $loans = $this->loanModel->readAllPending();
        
        // Enhance loans with user and material information
        $enhancedLoans = $this->enhanceLoanData($loans);
        
        // Load view
        require_once __DIR__ . '/../Views/loans/admin-pending-loans.php';
    }

    // User: Get all loans for the current user
    public function getUserLoans() {
        // Check if user is authenticated
        $this->ensureAuthenticated();
        
        // Get all loans for the current user
        $loans = $this->loanModel->readAllByUserId($_SESSION['user_id']);
        
        // Enhance loans with material information
        $enhancedLoans = [];
        
        foreach ($loans as $loan) {
            // Get material information
            $this->materialModel->readById($loan['id_materiel']);
            
            // Enhance loan with additional information
            $enhancedLoan = [
                'id' => $loan['id'],
                'material_nom' => $this->materialModel->getNom(),
                'material_photo' => $this->materialModel->getPhoto(),
                'date_debut' => $loan['date_debut'],
                'date_fin' => $loan['date_fin'],
                'statut' => $loan['statut']
            ];
            
            $enhancedLoans[] = $enhancedLoan;
        }
        
        // Load view
        require_once __DIR__ . '/../Views/loans/user-loans.php';
    }

    // User: Get active and pending loans for the current user
    public function getUserActiveAndPendingLoans() {
        // Check if user is authenticated
        $this->ensureAuthenticated();
        
        // Get active and pending loans for the current user
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT * FROM prets 
                WHERE id_utilisateur = :user_id 
                AND statut IN ('en_attente', 'accepte', 'en_cours') 
                ORDER BY date_debut DESC
            ");
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $loans = $stmt->fetchAll();
            
            // Enhance loans with material information
            $enhancedLoans = [];
            
            foreach ($loans as $loan) {
                // Get material information
                $this->materialModel->readById($loan['id_materiel']);
                
                // Enhance loan with additional information
                $enhancedLoan = [
                    'id' => $loan['id'],
                    'material_nom' => $this->materialModel->getNom(),
                    'material_photo' => $this->materialModel->getPhoto(),
                    'date_debut' => $loan['date_debut'],
                    'date_fin' => $loan['date_fin'],
                    'statut' => $loan['statut']
                ];
                
                $enhancedLoans[] = $enhancedLoan;
            }
            
            // Load view
            require_once __DIR__ . '/../Views/loans/user-active-pending-loans.php';
            
        } catch(PDOException $e) {
            $_SESSION['error'] = "Erreur de récupération des prêts: " . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    // Admin: Accept a loan
    public function acceptLoan() {
        // Check if user is admin
        $this->ensureAdmin();
        
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de prêt invalide";
            header('Location: index.php?action=getPendingLoans');
            exit();
        }
        
        // Load the loan
        if ($this->loanModel->readById($id)) {
            // Check if the loan is pending
            if ($this->loanModel->getStatut() !== 'en_attente') {
                $_SESSION['error'] = "Ce prêt n'est pas en attente d'approbation";
                header('Location: index.php?action=getPendingLoans');
                exit();
            }
            
            // Approve the loan
            if ($this->loanModel->approve()) {
                $_SESSION['success'] = "Prêt approuvé avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de l'approbation du prêt";
            }
        } else {
            $_SESSION['error'] = "Prêt non trouvé";
        }
        
        header('Location: index.php?action=getPendingLoans');
        exit();
    }

    // Admin: Reject a loan
    public function rejectLoan() {
        // Check if user is admin
        $this->ensureAdmin();
        
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de prêt invalide";
            header('Location: index.php?action=getPendingLoans');
            exit();
        }
        
        // Load the loan
        if ($this->loanModel->readById($id)) {
            // Check if the loan is pending
            if ($this->loanModel->getStatut() !== 'en_attente') {
                $_SESSION['error'] = "Ce prêt n'est pas en attente d'approbation";
                header('Location: index.php?action=getPendingLoans');
                exit();
            }
            
            // Reject the loan
            if ($this->loanModel->reject()) {
                $_SESSION['success'] = "Prêt refusé";
            } else {
                $_SESSION['error'] = "Erreur lors du refus du prêt";
            }
        } else {
            $_SESSION['error'] = "Prêt non trouvé";
        }
        
        header('Location: index.php?action=getPendingLoans');
        exit();
    }
}
?>