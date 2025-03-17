<?php
session_start();
require '../../../private/database/database.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    // Validation des champs
    if (empty($nom)) $errors[] = "Le nom est requis";
    if (empty($prenom)) $errors[] = "Le prénom est requis";
    if (empty($username)) $errors[] = "Le nom d'utilisateur est requis";
    if (empty($email)) {
        $errors[] = "L'email est requis";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format d'email invalide";
    }
    if (empty($mot_de_passe)) {
        $errors[] = "Le mot de passe est requis";
    } elseif (strlen($mot_de_passe) < 4) {
        $errors[] = "Le mot de passe doit contenir au moins 4 caractères";
    }

    if (empty($errors)) {
        try {
            // Vérification email unique
            $checkEmail = $pdo->prepare("SELECT user_id FROM users WHERE email = ?");
            $checkEmail->execute([$email]);
            
            if ($checkEmail->rowCount() > 0) {
                $errors[] = "Cet email est déjà utilisé";
            } else {
                $checkUsername = $pdo->prepare("SELECT user_id FROM users WHERE username = ?");
                $checkUsername->execute([$username]);
                
                if ($checkEmail->rowCount() > 0) {
                    $errors[] = "Ce nom d'utilisateur est déjà utilisé";
                } else {
                    // Insertion utilisateur
                    $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (last_name, first_name, email, password_hash, username) 
                                        VALUES (:nom, :prenom, :email, :mot_de_passe, :username)");
                    
                    $stmt->execute([
                        ':nom' => $nom,
                        ':prenom' => $prenom,
                        ':email' => $email,
                        ':mot_de_passe' => $hashedPassword,
                        ':username' => $username
                    ]);

                    if ($stmt->rowCount() > 0) {
                        $success = true;
                        $getUID = $pdo->prepare("SELECT uid FROM users WHERE email = ?");
                        $getUID->execute([$email]);
                        $uid = $getUID->fetchColumn();

                        $_SESSION['user'] = [
                            'uid' => $uid,
                            'username' => $username,
                            'role' => 'user'
                        ];

                        $_SESSION['inscription_success'] = true;
                        header("Refresh: 0; url=../../index.php");
                        }
                    }
                }
            } catch (PDOException $e) {
                $errors[] = "Erreur technique : " . $e->getMessage();
            }
    }
}
?>