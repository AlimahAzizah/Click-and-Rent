<?php
session_start();
require_once '../../../private/database/database.php';

// Vérifier la connexion à la base de données
if (!isset($pdo)) {
    die("Erreur : Impossible de se connecter à la base de données.");
}

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    // Validation des champs
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide.";
    }
    if (empty($mot_de_passe)) {
        $errors[] = "Le mot de passe est requis.";
    }

    if (empty($errors)) {
        try {
            $checkEmail = $pdo->prepare("SELECT email, password_hash FROM utilisateurs WHERE email = ?");
            $checkEmail->execute([$email]);
            $user = $checkEmail->fetch();

            if ($user) {
                // Vérification du mot de passe
                if (password_verify($mot_de_passe, $user['password_hash'])) {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['user_statut'] = 'connected';
                    header('Location: ../../index.php');
                    exit();
                } else {
                    $errors[] = "Le mot de passe est incorrect.";
                }
            } else {
                $errors[] = "L'adresse email n'existe pas.";
            }
        } catch (PDOException $e) {
            error_log("Erreur technique : " . $e->getMessage()); // Log de l'erreur
            $errors[] = "Une erreur technique est survenue. Veuillez réessayer plus tard.";
        }
    }

    // ✅ Stocker les erreurs et rediriger vers index.php
    $_SESSION['errors'] = $errors;
    header('Location: index.php');
    exit();
}
?>
