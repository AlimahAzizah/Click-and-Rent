<?php
// Start session
session_start();

// Include necessary files
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/Models/Database.php';

$authController = new AuthController();
$authMiddleware = new AuthMiddleware();

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
        case 'error403':
            include __DIR__ . '/../app/Views/Errors/403.php';
            exit;
        case 'error404':
            include __DIR__ . '/../app/Views/Errors/404.php';
            exit;
        case 'error500':
            include __DIR__ . '/../app/Views/Errors/500.php';
            exit;
        case 'showUserDashboard':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/dashboard.php';
            include __DIR__ . '/../app/Views/Layouts/footer.php';

            exit;

        case 'showPanier':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/panier.php';

            exit;    
        case 'showAdminDashboard':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($authMiddleware->adminOnly()) {
                include __DIR__ . '/../app/Views/Admin/dashboard.php';
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        
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
