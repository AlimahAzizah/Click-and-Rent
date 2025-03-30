<?php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $user->login($email, $password);
    if ($user->getId() !== null) {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_role'] = $user->getRole();
        header('Location: /dashboard');
        exit();
    } else {
        $_SESSION['error'] = "Identifiants incorrects";
        header('Location: /login');
        exit();
    }
}

?>