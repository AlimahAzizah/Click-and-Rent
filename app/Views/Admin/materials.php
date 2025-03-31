<!-- Views/admin/materials.php -->
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Matériels</h1>
        <a href="index.php?action=showCreateForm" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un Matériel
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>État</th>
                        <th>Disponibilité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($materials as $material): ?>
                        <tr>
                            <td><?= $material['id'] ?></td>
                            <td>
                                <img src="<?= $material['photo'] ?>" class="img-thumbnail" 
                                     style="max-width: 50px;" alt="<?= $material['nom'] ?>">
                            </td>
                            <td><?= $material['nom'] ?></td>
                            <td><?= substr($material['description'], 0, 50) . '...' ?></td>
                            <td><?= $material['etat'] ?></td>
                            <td>
                                <span class="badge <?= $material['disponibilite'] ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $material['disponibilite'] ? 'Disponible' : 'Indisponible' ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="index.php?action=showEditForm&id=<?= $material['id'] ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?action=deleteMaterial&id=<?= $material['id'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php if($material['disponibilite']): ?>
                                        <a href="index.php?action=markAsUnavailable&id=<?= $material['id'] ?>" 
                                           class="btn btn-secondary btn-sm">
                                            <i class="fas fa-ban"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?action=markAsAvailable&id=<?= $material['id'] ?>" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
