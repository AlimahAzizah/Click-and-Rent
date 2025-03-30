<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="src/css/register.css">
</head>
<body>
    <div class="Inscription">
        <div class="SectionLogo">
            <img class="Fermer1" src="assets/images/fermer.png" alt="Fermer">
            <div class="ClickRent">CLICK&RENT</div>
        </div>
        <div class="SectionInscription">
            <div class="presentation">
                <img class="Image" src="assets/images/connexion.png" alt="Image de présentation">
            </div>
            
            <div class="SeInscrire">
                <img class="Icon_inscription" src="assets/images/inscription.png" alt="Icone principale">
                <div class="PourGRerVosLocations">
                    <span>Louez en toute simplicité !</span>
                </div>
                <div class="ConnectezVousOuCrEzVotreCompte">
                    <span>et créez votre compte</span>
                </div>
                <form action= "../public/index.php?action=register" method="POST">
                    <div class="InputNom">
                        <input type="text" placeholder="Votre nom">
                    </div>
                    <div class="InputPrenom">
                        <input type="text" placeholder="Votre prénom">
                    </div>
                    <div class="InputEmail">
                        <input type="email" placeholder="Votre adresse mail">
                    </div>
                    <div class="InputMotDePasse">
                        <input type="password" placeholder="Votre mot de passe">
                    </div>
                    <div class="Button">
                        <button type="submit">Créer un compte</button>
                    </div>
                </form>
                <div class="VousPossedezDejaUnCompte">
                    <span>Vous possédez déjà un compte ? <a class="link" href="../public/index.php?action=showLogin">Se connecter !</a></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
