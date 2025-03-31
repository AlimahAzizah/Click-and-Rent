<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordonnées</title>
    <link rel="stylesheet" href="src/css/dashboard.css">
</head>
<body>
<section class="user-dashboard">
    <div class="user-header">
        <div class="avatar">JD</div>
        
        <div class="user-info">
            <div class="username">John DOE</div>
        </div>
        
        <div class="logout-container">
            <a href="#" class="logout-btn">ME DÉCONNECTER</a>
        </div>
    </div>

    <nav class="navigation">
        <button class="navigation__tab"><a href="my-account.php">Mes informations</a></button>
        <button class="navigation__tab"><a href="loans-history.php">Historique des prêts</a></button>
        <button class="navigation__tab"><a href="my-current-loans.php">Demandes en cours</a></button>
    </nav>
</section>

<section class="user-form">
    <form class="coordonnees-form">
        <h2 class="form-title">COORDONNÉES</h2>
        
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <button type="submit" class="validate-form-btn">Valider</button>
    </form>
</section>


        
   
</body>
</html>