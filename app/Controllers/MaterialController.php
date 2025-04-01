<?php

require_once __DIR__ . '/../Models/Material.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Database.php';

class MaterialController {
    private $materialModel;
    private $userModel;

    public function __construct() {
        $this->materialModel = new Material();
        $this->userModel = new User();
    }

    // Admin: Get all materials information
    public function getAllMaterials() {
        // Check if user is admin
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }

        $materials = $this->materialModel->readAll();
        require_once __DIR__ . '/../Views/materials/admin-list.php';
        return $materials;
    }

    // Admin: Create a new material
    public function createMaterial() {
        // Check if user is admin
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => htmlspecialchars($_POST['nom']),
                'categorie' => htmlspecialchars($_POST['categorie']),
                'etat' => htmlspecialchars($_POST['etat']),
                'description' => htmlspecialchars($_POST['description']),
                'disponibilite' => isset($_POST['disponibilite']) ? true : false
            ];

            // Handle photo upload
            $photoPath = $this->handlePhotoUpload();
            if ($photoPath !== false) {
                $data['photo'] = $photoPath;
            } else {
                // If photo upload failed but it's not required, we can continue
                // Otherwise, redirect back with error
                if (isset($_SESSION['error'])) {
                    header('Location: index.php?action=showCreateForm');
                    exit();
                }
                $data['photo'] = ''; // Default empty photo
            }

            // Validate material data
            if ($this->validateMaterialData($data)) {
                if ($this->materialModel->create(
                    $data['nom'],
                    $data['description'],
                    $data['categorie'],
                    $data['etat'],
                    $data['photo'],
                    $data['disponibilite']
                )) {
                    $_SESSION['success'] = "Matériel créé avec succès";
                    header('Location: index.php?action=showAdminMaterials');
                    exit();
                } else {
                    $_SESSION['error'] = "Erreur lors de la création du matériel";
                }
            }

            // If validation failed or creation failed, redirect back to form
            header('Location: index.php?action=showCreateForm');
            exit();
        }
    }

    // Admin: Update an existing material
    public function updateMaterial() {
        // Check if user is admin
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                $_SESSION['error'] = "ID de matériel invalide";
                header('Location: index.php?action=getAllMaterials');
                exit();
            }

            // Load the existing material
            if (!$this->materialModel->readById($id)) {
                $_SESSION['error'] = "Matériel non trouvé";
                header('Location: index.php?action=getAllMaterials');
                exit();
            }

            $data = [
                'id' => $id,
                'nom' => htmlspecialchars($_POST['nom']),
                'categorie' => htmlspecialchars($_POST['categorie']),
                'etat' => htmlspecialchars($_POST['etat']),
                'description' => htmlspecialchars($_POST['description']),
                'disponibilite' => isset($_POST['disponibilite']) ? true : false
            ];

            // Handle photo upload
            $photoPath = $this->handlePhotoUpload();
            if ($photoPath !== false) {
                $data['photo'] = $photoPath;
            } else {
                // If no new photo was uploaded or there was an error, keep the existing photo
                if (!isset($_SESSION['error'])) {
                    $data['photo'] = $this->materialModel->getPhoto();
                } else {
                    header('Location: index.php?action=showUpdateForm&id=' . $id);
                    exit();
                }
            }

            // Validate material data
            if ($this->validateMaterialData($data)) {
                // Update the model with new data
                $this->materialModel->setNom($data['nom']);
                $this->materialModel->setDescription($data['description']);
                $this->materialModel->setCategorie($data['categorie']);
                $this->materialModel->setEtat($data['etat']);
                $this->materialModel->setPhoto($data['photo']);
                $this->materialModel->setDisponibilite($data['disponibilite']);

                if ($this->materialModel->update()) {
                    $this->materialModel->update();
                    $_SESSION['success'] = "Matériel mis à jour avec succès";
                    header('Location: index.php?action=showAdminMaterials');
                    exit();
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour du matériel";
                }
            }

            // If validation failed or update failed, redirect back to form
            header('Location: index.php?action=showUpdateForm&id=' . $id);
            exit();
        }
    }

        
    // Admin: Delete an existing material
    public function deleteMaterial() {
        // Check if user is admin
        session_start();
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=getAllMaterials');
            exit();
        }

        // Load the material to get info for potential cleanup (e.g., delete photo file)
        if ($this->materialModel->readById($id)) {
            // Delete photo file if it exists
            $photo = $this->materialModel->getPhoto();
            if (!empty($photo) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $photo)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $photo);
            }

            // Implement delete functionality since it's not available in the model
            try {
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("DELETE FROM materiels WHERE id = :id");
                $stmt->bindParam(':id', $id);
                
                if ($stmt->execute()) {
                    $stmt->execute();
                    $_SESSION['success'] = "Matériel supprimé avec succès";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression du matériel";
                }
            } catch(PDOException $e) {
                $_SESSION['error'] = "Erreur de base de données: " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
        }

        header('Location: index.php?action=getAllMaterials');
        exit();
    }

    // Show the create form for admin
    public function showCreateForm() {
        // Check if user is admin
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }

        require_once __DIR__ . '/../Views/materials/create.php';
    }

    // Show the update form for admin
    public function showUpdateForm() {
        // Check if user is admin
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || !$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php?action=showLogin');
            exit();
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=showAdminMaterials');
            exit();
        }

        if ($this->materialModel->readById($id)) {
            $material = [
                'id' => $this->materialModel->getId(),
                'nom' => $this->materialModel->getNom(),
                'description' => $this->materialModel->getDescription(),
                'categorie' => $this->materialModel->getCategorie(),
                'etat' => $this->materialModel->getEtat(),
                'photo' => $this->materialModel->getPhoto(),
                'disponibilite' => $this->materialModel->getDisponibilite()
            ];
            require_once __DIR__ . '/../Views/materials/update.php';
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
            header('Location: index.php?action=showAdminMaterials');
            exit();
        }
    }
    
    // Function for everyone to search for a material
    public function searchMaterials() {
        $query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';
        $materials = [];

        if (!empty($query)) {
            $materials = $this->materialModel->search($query);
        }

        require_once __DIR__ . '/../Views/material/search-results.php';
    }

    // Function to get materials for the catalogue (for everyone)
    public function getMaterialsCatalogue() {
        $materials = $this->materialModel->readAllAvailable();
        require_once __DIR__ . '/../Views/material/catalogue.php';
    }

    // Function to show material details
    public function showMaterialDetails() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=getMaterialsCatalogue');
            exit();
        }

        if ($this->materialModel->readById($id)) {
            $material = [
                'id' => $this->materialModel->getId(),
                'nom' => $this->materialModel->getNom(),
                'categorie' => $this->materialModel->getCategorie(),
                'description' => $this->materialModel->getDescription(),
                'etat' => $this->materialModel->getEtat(),
                'photo' => $this->materialModel->getPhoto(),
                'disponibilite' => $this->materialModel->getDisponibilite()
            ];
            require_once __DIR__ . '/../Views/materials/details.php';
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
            header('Location: index.php?action=getMaterialsCatalogue');
            exit();
        }
    }

    // Function to mark a material as unavailable
    public function markAsUnavailable() {
        // Check if user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action";
            header('Location: index.php?action=showLogin');
            exit();
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=getAllMaterials');
            exit();
        }

        if ($this->materialModel->readById($id)) {
            if ($this->materialModel->markAsUnavailable()) {
                $_SESSION['success'] = "Matériel marqué comme indisponible";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour de la disponibilité";
            }
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
        }

        // Redirect based on user role
        if ($this->isAdmin()) {
            header('Location: index.php?action=getAllMaterials');
        } else {
            header('Location: index.php?action=getMaterialsCatalogue');
        }
        exit();
    }
    
    // Function to mark a material as available
    public function markAsAvailable() {
        // Check if user is logged in
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action";
            header('Location: index.php?action=showLogin');
            exit();
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=getAllMaterials');
            exit();
        }

        if ($this->materialModel->readById($id)) {
            if ($this->materialModel->markAsAvailable()) {
                $_SESSION['success'] = "Matériel marqué comme disponible";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour de la disponibilité";
            }
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
        }

        // Redirect based on user role
        if ($this->isAdmin()) {
            header('Location: index.php?action=getAllMaterials');
        } else {
            header('Location: index.php?action=getMaterialsCatalogue');
        }
        exit();
    }

    // Function to validate material data
    private function validateMaterialData($data) {
        if (empty($data['nom'])) {
            $_SESSION['error'] = "Le nom du matériel est obligatoire";
            return false;
        }

        if (empty($data['description'])) {
            $_SESSION['error'] = "La description du matériel est obligatoire";
            return false;
        }

        if (empty($data['etat'])) {
            $_SESSION['error'] = "L'état du matériel est obligatoire";
            return false;
        }

        if (empty($data['categorie'])) {
            $_SESSION['error'] = "La catégorie du matériel est obligatoire";
            return false;
        }

        return true;
    }

    // Function to handle photo upload
    private function handlePhotoUpload() {
        // Check if file was uploaded
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
            return false; // No file uploaded
        }

        // Check for upload errors
        if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Erreur lors de l'upload de la photo: " . $this->getUploadErrorMessage($_FILES['photo']['error']);
            return false;
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['photo']['type'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "Type de fichier non autorisé. Seuls les formats JPEG, PNG et GIF sont acceptés.";
            return false;
        }

        // Validate file size (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if ($_FILES['photo']['size'] > $maxSize) {
            $_SESSION['error'] = "La taille du fichier dépasse la limite autorisée (5MB).";
            return false;
        }

        // Create upload directory if it doesn't exist
        $uploadDir = __DIR__ . '/../public/uploads/materials/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $uploadPath = $uploadDir . $filename;

        // Move uploaded file to destination
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
            // Return the relative path for database storage
            return 'uploads/materials/' . $filename;
        } else {
            $_SESSION['error'] = "Erreur lors de l'enregistrement de la photo.";
            return false;
        }
    }

    // Helper function to get upload error messages
    private function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "La taille du fichier dépasse la directive upload_max_filesize dans php.ini.";
            case UPLOAD_ERR_FORM_SIZE:
                return "La taille du fichier dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML.";
            case UPLOAD_ERR_PARTIAL:
                return "Le fichier n'a été que partiellement téléchargé.";
            case UPLOAD_ERR_NO_FILE:
                return "Aucun fichier n'a été téléchargé.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Dossier temporaire manquant.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Échec de l'écriture du fichier sur le disque.";
            case UPLOAD_ERR_EXTENSION:
                return "Une extension PHP a arrêté le téléchargement du fichier.";
            default:
                return "Erreur inconnue.";
        }
    }

    // Helper function to check if the user is an admin
    private function isAdmin() {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $this->userModel->readById($_SESSION['user_id']);
        return $this->userModel->isAdmin();
    }
}

?>