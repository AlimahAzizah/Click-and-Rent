<?php
session_start();

require_once 'private/config/config.php';

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
            $checkEmail = $pdo->prepare("SELECT email, mot_de_passe FROM utilisateurs WHERE email = ?");
            $checkEmail->execute([$email]);
            
            if ($checkEmail->rowCount() <= 0) {
                $errors[] = "Cet email n'existe pas.";
            } else { 
                $user = $checkEmail->fetch();
                if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                    $success = true;
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['user_statut'] = 'connected';
                    header('Location: chat_bot/index.php');
                } else {
                    $errors[] = "Mot de passe incorrect.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur technique : " . $e->getMessage();
        }
    }
}

?>