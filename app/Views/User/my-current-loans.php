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
                <a href="#" class="logout-btn">ME DÉCONNECTER</a>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php?action=showMyAccount">Mes informations</a></li>
                <li class="nav-item"><a href="index.php?action=showLoanHistory">Historique des prêts</a></li>
                <li class="nav-item"><a href="index.php?action=showMyCurrentLoan">Demandes en cours</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="table-container">
                <h1 class="form-title">Demande en cours</h1>
                
                <div class="loans-table-container">
                        <table class="loans-table">
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
                                    <td>Ordinateur portable HP EliteBook</td>
                                    <td>15/03/2023</td>
                                    <td>30/03/2023</td>
                                    <td><span class="status-badge en_cours">En attente</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>