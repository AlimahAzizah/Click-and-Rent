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
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>État</th>
                            <th>Quantité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>MAT-001</td>
                            <td>Ordinateur Portable HP EliteBook</td>
                            <td>Informatique</td>
                            <td><span class="status-badge new">Neuf</span></td>
                            <td>15</td>
                            <td class="actions">
                                <button class="edit-btn" title="Modifier">✏️</button>
                                <button class="delete-btn" title="Supprimer">🗑️</button>
                                <button class="details-btn" title="Voir détails">👁️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>MAT-002</td>
                            <td>Imprimante Laser Epson</td>
                            <td>Bureautique</td>
                            <td><span class="status-badge good-state">Bon état</span></td>
                            <td>8</td>
                            <td class="actions">
                                <button class="edit-btn" title="Modifier">✏️</button>
                                <button class="delete-btn" title="Supprimer">🗑️</button>
                                <button class="details-btn" title="Voir détails">👁️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>MAT-003</td>
                            <td>Vidéoprojecteur BenQ</td>
                            <td>Audiovisuel</td>
                            <td><span class="status-badge out-of-service">Hors service</span></td>
                            <td>2</td>
                            <td class="actions">
                                <button class="edit-btn" title="Modifier">✏️</button>
                                <button class="delete-btn" title="Supprimer">🗑️</button>
                                <button class="details-btn" title="Voir détails">👁️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        
    </div>
</body>
</html>