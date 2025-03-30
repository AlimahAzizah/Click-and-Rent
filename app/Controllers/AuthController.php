<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Database.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }

    // Show the login form
    public function showLogin() {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Handle the login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = htmlspecialchars($_POST['password']);

            if ($this->userModel->readByEmail($email)) {
                if ($this->userModel->login($email, $password)) {
                    session_start();
                    $_SESSION['user_id'] = $this->userModel->getId();
                    $_SESSION['user_role'] = $this->userModel->getRole();
                    
                    header('Location: index.php?action=showUserDashboard');
                    exit();
                }
            }
            
            $_SESSION['error'] = "Identifiants incorrects";
            header('Location: index.php?action=showLogin');
            exit();
        }
    }

    // Show the registration form
    public function showRegister() {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // Handle the registration
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => htmlspecialchars($_POST['nom']),
                'prenom' => htmlspecialchars($_POST['prenom']),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'password' => $_POST['password'],
                'password_confirm' => $_POST['password_confirm']
            ];

            if ($this->validateRegistration($data)) {
                if ($this->userModel->create($data['nom'], $data['prenom'], $data['email'], $data['password'])) {
                    $_SESSION['success'] = "Inscription réussie ! Veuillez vous connecter.";
                    header('Location: index.php?action=showLogin');
                    exit();
                }
            }
            
            header('Location: index.php?action=showRegister');
            exit();
        }
    }

    // Validate the registration form
    private function validateRegistration($data) {
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email'])) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Format d'email invalide";
            return false;
        }

        if ($this->userModel->readByEmail($data['email'])) {
            $_SESSION['error'] = "Cet email est déjà utilisé";
            return false;
        }

        if ($data['password'] !== $data['password_confirm']) {
            $_SESSION['error'] = "Les mots de passe ne correspondent pas";
            return false;
        }

        if (strlen($data['password']) < 8) {
            $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères";
            return false;
        }

        return true;
    }

    // Logout the user
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        header('Location: /index.php?action=showLogin');
        exit();
    }
}
?>
