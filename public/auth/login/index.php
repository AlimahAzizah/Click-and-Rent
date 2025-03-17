<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">

        <h1 class="title">Bienvenue</h1><br>
        
        <form action="add.php" method="post">
            <label for="email"> Email </label>
            <input type="email" name="email" id="email" placeholder="E-mail" required>

            <label for="mot_de_passe"> Mot de passe </label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required minlength="4" placeholder="Mot de passe">

            <div class="button">
                <button type="submit" id="login" value="login">Se connecter</button>
            </div>
        </form>

        <div class ="complement">
        <p>Vous n’avez pas de compte ? <a href="../registration">S’inscire !</a></p>

        <a href="#">Mot de passe oublié ?</a>
        </div>
    </div>

</body>
</html>