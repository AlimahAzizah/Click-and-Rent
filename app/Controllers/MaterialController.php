<?php
require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/Material.php';
require_once __DIR__ . '/../Middleware/AdminMiddleware.php';


class MaterialController {
    private $materialModel;
    private $adminMiddleware;

    public function __construct() {
        $this->materialModel = new Material();
        $this->adminMiddleware = new AdminMiddleware();
    }

    // User-facing material display
    public function showAllMaterials() {
        $materials = $this->materialModel->readAll();
        require_once __DIR__ . '/../Views/material/list.php';
    }

    // Admin-only material management interface
    public function getAllMaterials() {
        // Check admin permissions
        $this->adminMiddleware->handle();
        
        $materials = $this->materialModel->readAll();
        require_once __DIR__ . '/../Views/admin/materials.php';
    }

    // Show all available materials
    public function showAvailableMaterials() {
        $materials = $this->materialModel->readAllAvailable();
        require_once __DIR__ . '/../Views/material/available.php';
    }

    // Show single material details
    public function showMaterial($id) {
        $this->materialModel->readById($id);
        require_once __DIR__ . '/../Views/material/details.php';
    }

    // Admin-only creation form
    public function showCreateForm() {
        $this->adminMiddleware->handle();
        require_once __DIR__ . '/../Views/material/create.php';
    }

    // Admin-only creation processing
    public function createMaterial() {
        $this->adminMiddleware->handle();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = htmlspecialchars($_POST['nom']);
            $description = htmlspecialchars($_POST['description']);
            $etat = htmlspecialchars($_POST['etat']);
            $photo = $_POST['photo']; // In a real app, would handle file upload
            $disponibilite = isset($_POST['disponibilite']) ? true : false;
            
            if ($this->validateMaterialData($nom, $description, $etat)) {
                $materialId = $this->materialModel->create($nom, $description, $etat, $photo, $disponibilite);
                if ($materialId) {
                    $_SESSION['success'] = "Matériel créé avec succès";
                    header('Location: index.php?action=showMaterial&id=' . $materialId);
                    exit();
                } else {
                    $_SESSION['error'] = "Erreur lors de la création du matériel";
                }
            }
            
            header('Location: index.php?action=showCreateForm');
            exit();
        }
    }

    // Admin-only edit form
    public function showEditForm($id) {
        $this->adminMiddleware->handle();
        
        if ($this->materialModel->readById($id)) {
            require_once __DIR__ . '/../Views/material/edit.php';
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
            header('Location: index.php?action=getAllMaterials');
            exit();
        }
    }

    // Admin-only update processing
    public function updateMaterial() {
        $this->adminMiddleware->handle();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            if ($this->materialModel->readById($id)) {
                $this->materialModel->setNom(htmlspecialchars($_POST['nom']));
                $this->materialModel->setDescription(htmlspecialchars($_POST['description']));
                $this->materialModel->setEtat(htmlspecialchars($_POST['etat']));
                $this->materialModel->setPhoto($_POST['photo']);
                $this->materialModel->setDisponibilite(isset($_POST['disponibilite']) ? true : false);
                
                if ($this->validateMaterialData($this->materialModel->getNom(), 
                                               $this->materialModel->getDescription(), 
                                               $this->materialModel->getEtat())) {
                    if ($this->materialModel->update()) {
                        $_SESSION['success'] = "Matériel mis à jour avec succès";
                        header('Location: index.php?action=showMaterial&id=' . $id);
                        exit();
                    } else {
                        $_SESSION['error'] = "Erreur lors de la mise à jour du matériel";
                    }
                }
                
                header('Location: index.php?action=showEditForm&id=' . $id);
                exit();
            } else {
                $_SESSION['error'] = "Matériel non trouvé";
                header('Location: index.php?action=getAllMaterials');
                exit();
            }
        }
    }

    // Admin-only delete function
    public function deleteMaterial($id) {
        $this->adminMiddleware->handle();
        
        if ($this->materialModel->readById($id)) {
            if ($this->materialModel->delete()) {
                $_SESSION['success'] = "Matériel supprimé avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression du matériel";
            }
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
        }
        
        header('Location: index.php?action=getAllMaterials');
        exit();
    }

    // Mark material as available
    public function markAsAvailable($id) {
        if ($this->materialModel->readById($id)) {
            if ($this->materialModel->markAsAvailable()) {
                $_SESSION['success'] = "Matériel marqué comme disponible";
            } else {
                $_SESSION['error'] = "Erreur lors du changement de statut";
            }
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
        }
        
        header('Location: index.php?action=showMaterial&id=' . $id);
        exit();
    }

    // Mark material as unavailable
    public function markAsUnavailable($id) {
        if ($this->materialModel->readById($id)) {
            if ($this->materialModel->markAsUnavailable()) {
                $_SESSION['success'] = "Matériel marqué comme indisponible";
            } else {
                $_SESSION['error'] = "Erreur lors du changement de statut";
            }
        } else {
            $_SESSION['error'] = "Matériel non trouvé";
        }
        
        header('Location: index.php?action=showMaterial&id=' . $id);
        exit();
    }

    // Search materials
    public function searchMaterials() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
            $query = htmlspecialchars($_GET['query']);
            $materials = $this->materialModel->search($query);
            require_once __DIR__ . '/../Views/material/search_results.php';
        } else {
            header('Location: index.php?action=showAllMaterials');
            exit();
        }
    }

    // Validate material data
    private function validateMaterialData($nom, $description, $etat) {
        if (empty($nom) || empty($description) || empty($etat)) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            return false;
        }
        
        return true;
    }
}

?>