<?php

require_once __DIR__ . '/../Models/Material.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Database.php';

class CartController {
    private $materialModel;
    private $userModel;
    
    public function __construct() {
        $this->materialModel = new Material();
        $this->userModel = new User();
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
    
    // Add an item to the cart
    public function addToCart($id_materiel) {
        // Check if user is authenticated
        $this->ensureAuthenticated();
        
        // Get material ID from request
        $id_materiel = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id_materiel) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=getMaterialsCatalogue');
            exit();
        }
        
        // Check if the material exists and is available
        if (!$this->materialModel->readById($id_materiel)) {
            $_SESSION['error'] = "Ce matériel n'existe pas";
            header('Location: index.php?action=getMaterialsCatalogue');
            exit();
        }
        
        if (!$this->materialModel->getDisponibilite()) {
            $_SESSION['error'] = "Ce matériel n'est pas disponible pour l'emprunt";
            header('Location: index.php?action=getMaterialsCatalogue');
            exit();
        }
        
        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Check if the material is already in the cart
        if (in_array($id_materiel, $_SESSION['cart'])) {
            $_SESSION['info'] = "Ce matériel est déjà dans votre panier";
        } else {
            // Add the material to the cart
            $_SESSION['cart'][] = $id_materiel;
            $_SESSION['success'] = "Matériel ajouté au panier avec succès";
        }
        
        // Redirect to the cart page or back to the catalogue
        header('Location: index.php?action=showPanier');
        exit();
    }
    public function removeFromCart() {
        $this->ensureAuthenticated();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_write_close(); // Release session lock for concurrent access
        session_start(); 
        
        $id_materiel = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id_materiel) {
            $_SESSION['error'] = "ID de matériel invalide";
            header('Location: index.php?action=showPanier');
            exit();
        }

        error_log("Initial Cart: " . print_r($_SESSION['cart'], true));
        
        if (!empty($_SESSION['cart'])) {
            // Remove all instances of the material ID (quantity support)
            $newCart = array_filter($_SESSION['cart'], function($item) use ($id_materiel) {
                return $item !== $id_materiel;
            });
            
            // Check if any items were removed
            if (count($newCart) !== count($_SESSION['cart'])) {
                $_SESSION['cart'] = array_values($newCart);
                $_SESSION['success'] = "Matériel retiré du panier avec succès";
                
                // Debug: Log updated cart state
                error_log("Updated Cart: " . print_r($_SESSION['cart'], true));
                
                // Force session write
                session_write_close();
            } else {
                $_SESSION['error'] = "Ce matériel n'est pas dans votre panier";
            }
        }
        
        header('Location: index.php?action=showPanier');
        exit();
    }
    
}
?>
