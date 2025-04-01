    <style>
        h1 {
            color: #424242;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th {
            background-color: #E91E63;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: normal;
            text-transform: uppercase;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }
        .badge-success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .badge-warning {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        .badge-danger {
            background-color: #ffebee;
            color: #c62828;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn-action {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            background-color: #E91E63;
        }
    </style>
<body>

<?php

require_once __DIR__ . '/../../Controllers/MaterialController.php';

$controller = new MaterialController();
$materials = $controller->getAllMaterials();

?>
    
    <table class="materials-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOM</th>
                <th>CATÉGORIE</th>
                <th>ÉTAT</th>
                <th>DISPONIBILITÉ</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materials as $material): ?>
            <tr>
                <td><?= $material['id'] ?></td>
                <td><?= $material['nom'] ?></td>
                <td><?= $material['categorie'] ?></td>
                <td>

                    <?php if ($material['etat'] === 'Neuf'): ?>
                        <span class="status-badge new">Neuf</span>
                    <?php elseif ($material['etat'] === 'Bon'): ?>
                        <span class="status-badge good-state">Bon</span>
                    <?php elseif ($material['etat'] === 'Moyen'): ?>
                        <span class="status-badge good-stateg">Moyen</span>
                    <?php else: ?>
                        <span class="status-badge out-of-service">Mauvais</span>
                    <?php endif; ?>
                </td>
                <td><?= $material['disponibilite'] ? 'Disponible' : 'Indisponible' ?></td>
                <td class="actions">
                    <a href="index.php?action=showUpdateForm&id=<?= $material['id'] ?>" class="edit-btn">✏️</a>
                    <a href="index.php?action=deleteMaterial&id=<?= $material['id'] ?>" class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ?')">🗑️</a>
                    <a href="index.php?action=showMaterialDetails&id=<?= $material['id'] ?>" class="details-btn">👁️</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
