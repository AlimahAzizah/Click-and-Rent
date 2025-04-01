<?php
// Start session
session_start();

// Include necessary files
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/Material.php';
require_once __DIR__ . '/../app/Models/Loan.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MaterialController.php';
require_once __DIR__ . '/../app/Middleware/AdminMiddleware.php';

$authController = new AuthController();
$adminMiddleware = new AdminMiddleware();
$materialController = new MaterialController();

// Handle different actions
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

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
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/Public/accueil.php';
             include __DIR__ . '/../app/Views/Layouts/footer.php';
            break;
        case 'showRegister':
            $authController->showRegister();
            break;
        case 'showLogin':
            $authController->showLogin();
            break;
        case 'error403':
            include __DIR__ . '/../app/Views/Errors/403.php'; // 403 Forbidden error page
            exit;
        case 'error404':
            include __DIR__ . '/../app/Views/Errors/404.php'; // 404 Not Found error page
            exit;
        case 'error500':
            include __DIR__ . '/../app/Views/Errors/500.php'; // 500 Internal Server Error page
            exit;
        case 'showUserDashboard':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/my-account.php';

            exit;

        case 'showMyAccount':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/my-account.php';

            exit;

        case 'showLoanHistory':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/loans-history.php';

            exit;
        
        case 'showMyCurrentLoan':   
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/my-current-loans.php';

            exit;

        case 'showPanier':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 
            
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/User/panier.php';

            exit;    
            
        case 'showAdminMaterials':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                include __DIR__ . '/../app/Views/Admin/materials.php';
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'showAdminLoanHistory':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                include __DIR__ . '/../app/Views/Admin/loan-history.php';
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;
        
        case 'showAdminCurrentLoan':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                include __DIR__ . '/../app/Views/Admin/current-loan.php';
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;
        
        case 'showAdminWaitingLoan':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                include __DIR__ . '/../app/Views/Admin/waiting-loan.php';
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'showCreateForm':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                $materialController->showCreateForm();
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'showUpdateForm':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                $materialController->showUpdateForm();
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'getAllMaterials':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                include __DIR__ . '/../app/Views/Admin/materials.php';
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'updateMaterial':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                $materialController->updateMaterial($id);
                header('Location: index.php?action=getAllMaterials');
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'createMaterial':
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                $materialController->createMaterial();
                header('Location: index.php?action=getAllMaterials');
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'deleteMaterial': 
            if (!isset($_SESSION['user_id'])) {
                $authController->showLogin();
                exit;
            } 

            if ($adminMiddleware->handle()) {
                $materialController->deleteMaterial($id);
                header('Location: index.php?action=getAllMaterials');
            } else {
                include __DIR__ . '/../app/Views/Errors/403.php';
            }
            exit;

        case 'showMaterialDetails':

            $materialController->showMaterialDetails($id);
            exit;

        case 'showBoutique':

            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/Public/boutique.php';
            include __DIR__ . '/../app/Views/Layouts/footer.php';
            exit;

        
        default:
            include __DIR__ . '/../app/Views/Layouts/header.php';
            include __DIR__ . '/../app/Views/Public/accueil.php';
            include __DIR__ . '/../app/Views/Layouts/footer.php';
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
