<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles/registration.css">
    <style>
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Formulaire d'inscription</h1>

            <form action="add.php" method="post">

            <label>Votre nom</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" placeholder="Votre nom" required>

            <label>Votre prénom</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" placeholder="Votre prénom" required>

            <label>Votre e-mail</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Votre e-mail" required>

            <label>Votre nom d'utilisateur</label>
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" placeholder="Votre nom d'utilisateur" required>

            <label>Votre mot de passe</label>
            <input type="password" name="mot_de_passe" placeholder="Votre mot de passe" required minlength="4" required>

            <button type="submit">S'inscrire</button>
        </form>

        <p>Déjà inscrit ? <a href="#">Connectez-vous ici</a></p>
    </div>
</body>
</html>