<?php
// Start session and implement security measures
session_start();

// Include necessary files
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Models/Database.php';

$authController = new AuthController();

// Handle different actions
$action = isset($_GET['action']) ? $_GET['action'] : null;

if ($action !== null) {
    switch ($action) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $authController->register();
            break;
        case 'logout':
             $authController->logout();
             break;
        case 'showRegister':
            $authController->showRegister();
            break;
        case 'showLogin':
            $authController->showLogin();
            break;
        default:
            include __DIR__ . '/../app/Views/Public/accueil.php';
            exit;
    }
} else {
    // Default to accueil page if no action is specified
    include __DIR__ . '/../app/Views/Layouts/header.php';
    include __DIR__ . '/../app/Views/Public/accueil.php';
    include __DIR__ . '/../app/Views/Layouts/footer.php';
    exit;
}
?>
