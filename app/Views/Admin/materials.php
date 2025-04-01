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
            <div class="table-header">
            </div>
            <div class="table-container">
            <h2>Liste des matériaux</h2>
            <a href="index.php?action=showCreateForm"><button>Ajouter du matériel</button></a>
                <?php include_once __DIR__ . '/../Materials/admin-list.php'; ?>
            </div>
        </section>
    </div>
</body>
</html>