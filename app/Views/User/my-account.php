<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord utilisateur</title>
    <link rel="stylesheet" href="src/css/dashboard.css">
</head>
<body>
    <header>
        <!-- Votre contenu de header ici -->
    </header>
    
    <div class="main-container">
        <div class="sidebar">
            <div class="user-profile">
                <div class="avatar">JD</div>
                <div class="username">John DOE</div>
                <a href="index.php?action=logout" class="logout-btn">ME DÉCONNECTER</a>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php?action=showMyAccount">Mes informations</a></li>
                <li class="nav-item"><a href="index.php?action=showLoanHistory">Historique des prêts</a></li>
                <li class="nav-item"><a href="index.php?action=showMyCurrentLoan">Demandes en cours</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="form-container">
                <h1 class="form-title">COORDONNÉES</h1>
                
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom">
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom">
                </div>
                
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email">
                </div>
                
                <button type="submit" class="submit-btn">Valider</button>
            </div>
        </div>
    </div>
</body>
</html>