<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLICK&RENT</title>
    <link rel="stylesheet" href="src/css/admin.css">
</head>
<body>
    <?php include_once 'header.php'; ?>
    
    <div class="main-container">
        <div class="sidebar">
            <div class="user-profile">
                <div class="avatar">JD</div>
                <div class="username">John DOE</div>
                <a href="#" class="logout-btn">ME DÉCONNECTER</a>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php?action=showMyAccount">Listes des matériaux</a></li>
                <li class="nav-item"><a href="index.php?action=showLoanHistory">Historique des prêts</a></li>
                <li class="nav-item"><a href="index.php?action=showMyCurrentLoan">Demandes en cours</a></li>
                <li class="nav-item"><a href="index.php?action=showMyCurrentLoan">Demandes en attente</a></li>
            </ul>
        </div>
        
        
    </div>
</body>
</html>