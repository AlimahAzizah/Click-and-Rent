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
            <a href="index.php?action=logout" class="logout-btn">ME DÉCONNECTER</a>
        </div>
    </div>

    <nav class="navigation">
        <button class="navigation__tab"><a href="index.php?action=showMyAccount">Mes informations</a></button>
        <button class="navigation__tab"><a href="index.php?action=showLoanHistory">Historique des prêts</a></button>
        <button class="navigation__tab"><a href="index.php?action=showMyCurrentLoan">Demandes en cours</a></button>
    </nav>
</section>

<section class="user-current">
    <table class="current-table">
        <thead>
            <tr>
                <th>Nom du produit</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Produit A</td>
                <td>15/01/2023</td>
                <td>20/02/2023</td>
                <td><span class="status-active">Accepté</span></td>
            </tr>
            <tr>
                <td>Produit B</td>
                <td>01/03/2023</td>
                <td>15/04/2023</td>
                <td><span class="status-ended">En attente</span></td>
            </tr>
            <!-- Ajoutez d'autres lignes selon vos besoins -->
        </tbody>
    </table>
</section>




        
   
</body>
</html>