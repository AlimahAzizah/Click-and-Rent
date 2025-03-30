<?php
// Start session and implement security measures
session_start();

// Session regeneration for security
if (isset($_SESSION['last_regeneration']) && time() - $_SESSION['last_regeneration'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Include necessary files
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Models/Database.php';

$authController = new AuthController();

// Handle different actions
$action = isset($_GET['action']) ? $_GET['action'] : 'showLogin';

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
    default:
        $authController->showLogin();
        break;
}

// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function checkRememberMeCookie() {
    if (isset($_COOKIE['remember_token']) && !empty($_COOKIE['remember_token'])) {
        $user = new User();
        $userId = $user->validateRememberToken($_COOKIE['remember_token']);
        if ($userId) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_role'] = $user->getRole();
            $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
            return true;
        }
    }
    return false;
}

// Initialize User model if logged in
$user = null;
if (isLoggedIn() || checkRememberMeCookie()) {
    $user = new User();
    $user->readById($_SESSION['user_id']);
    
    // Set IP if not already set
    if (!isset($_SESSION['user_ip'])) {
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    }
}

// Define routes that require authentication
$protected_routes = ['user-dashboard', 'profile', 'settings'];
$admin_routes = ['admin-dashboard', 'manage-users', 'system-settings'];

// Get the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Check authentication for protected routes
if (in_array($page, $protected_routes) && !isLoggedIn()) {
    // Redirect to login
    header('Location: index.php?page=login&redirect=' . urlencode($page));
    exit;
}

// Check admin rights for admin routes
if (in_array($page, $admin_routes) && (!isLoggedIn() || !$user->isAdmin())) {
    // Redirect to home or unauthorized page
    header('Location: index.php?page=unauthorized');
    exit;
}

// Process the request based on authentication status
if ($user && $user->isAdmin() && isset($_GET['page']) && in_array($_GET['page'], $admin_routes)) {
    // Admin area
    include __DIR__ . '/../app/Views/Admin/dashboard.php';
} else if ($user && isset($_GET['page']) && in_array($_GET['page'], $protected_routes)) {
    // User authenticated area
    include __DIR__ . '/../app/Views/User/dashboard.php';
} else {
    // Public area or specific pages
    switch ($page) {
        case 'login':
            include __DIR__ . '/../app/Views/Auth/login.php';
            break;
        case 'register':
            include __DIR__ . '/../app/Views/Auth/register.php';
            break;
        case 'logout':
            // Implement logout
            session_unset();
            session_destroy();
            if (isset($_COOKIE['remember_token'])) {
                setcookie('remember_token', '', time() - 3600, '/');
            }
            header('Location: index.php');
            exit;
        default:
            include __DIR__ . '/../app/Views/Public/accueil.php';
    }
}
?>
