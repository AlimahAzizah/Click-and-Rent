<?php
class AuthMiddleware {
    public function handle() {
        session_start();
        
        // Vérification du token "Se souvenir de moi"
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
            $userModel = new User();
            if ($userModel->findByRememberToken($_COOKIE['remember_token'])) {
                $_SESSION['user_id'] = $userModel->getId();
                $_SESSION['user_role'] = $userModel->getRole();
            }
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . __DIR__ . '/../../public/index.php?action=login');
            exit();
        }
    }

    public function adminOnly() {
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: ' . __DIR__ . '/../../public/index.php?action=error403');
            exit();
        }
    }
}
?>