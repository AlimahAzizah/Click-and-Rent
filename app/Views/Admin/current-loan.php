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
                <div class="avatar">A</div>
                <div class="username">Admin</div>
                <a href="index.php?action=logout" class="logout-btn">ME DÉCONNECTER</a>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php?action=showAdminMaterials">Listes des matériaux</a></li>
                <li class="nav-item"><a href="index.php?action=showAdminLoanHistory">Historique des prêts</a></li>
                <li class="nav-item"><a href="index.php?action=showAdminCurrentLoan">Demandes en cours</a></li>
                <li class="nav-item"><a href="index.php?action=showAdminWaitingLoan">Demandes en attente</a></li>
            </ul>
        </div>

        <section class="material_list">
            <div class="table-container">
                <table class="materials-table">
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
                            <td><span class="status-badge en_cours">En cours</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        
    </div>
</body>
</html>