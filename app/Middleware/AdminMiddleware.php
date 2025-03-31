<?php
class AdminMiddleware {
    public function handle() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in and has admin role
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // User is not an admin, redirect to home page
            $_SESSION['error'] = "Accès refusé. Vous devez être administrateur pour accéder à cette page.";
            header('Location: index.php');
            exit();
        } else {
            return true; // User is admin, allow access
        }
    }
}
