<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="src/css/login.css">
</head>
<body>
    <div class="Connexion">

        <div class="SectionLogo">
        <a href="../public/" class="link"><img class="Fermer1" src="assets/images/fermer.png" alt="Fermer"></a>
            <a href="../public/" class="cr-account-link"><div class="ClickRent">CLICK&RENT</div></a>
        </div>
        <div class="SectionConnexion">
            <div class="presentation">
                <img class="Image" src="assets/images/inscription_background.png" alt="Image de présentation">
            </div>
            
            <div class="SeConnecter">
                <img class="IconMain1" src="assets/images/icon_main.png" alt="Icone principale">
                <div class="PourGRerVosLocations">
                    <span>Pour gérer vos locations,<br/></span>
                </div>
                <div class="ConnectezVousOuCrEzVotreCompte">
                    <span>connectez-vous ou créez votre compte.</span>
                </div>
                <form action="../public/index.php?action=login" method="POST">
                    
                    <div class="InputEmail">
                        <input type="email" name="email" placeholder="Votre adresse mail" required>
                    </div>
                    <div class="InputMotDePasse">
                        <input type="password" name="password" placeholder="Votre mot de passe" required>
                    </div>
                    <button type="submit" class="Button">Se connecter</button>
                </form>
                <div class="VousNAvezPasEncoreDeCompteCrErVotreCompte">
                    <span>Vous n’avez pas encore de compte ! </span>
                    <a href="../public/index.php?action=showRegister" class="link">Créer votre compte !</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
