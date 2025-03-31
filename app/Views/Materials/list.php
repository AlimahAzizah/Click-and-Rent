<!-- Views/material/list.php -->
<div class="container mt-5">
    <h1 class="mb-4">Catalogue de Matériels</h1>
    
    <div class="row">
        <?php foreach($materials as $material): ?>
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <img src="<?= $material['photo'] ?>" class="card-img-top" alt="<?= $material['nom'] ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Nom du produit</h5>
                        <p class="card-text">
                            <span class="badge <?= $material['disponibilite'] ? 'badge-success' : 'badge-danger' ?>">
                                <?= $material['disponibilite'] ? 'Disponible' : 'Indisponible' ?>
                            </span>
                        </p>
                        <div class="mt-auto">
                            <a href="index.php?action=showMaterial&id=<?= $material['id'] ?>" 
                               class="btn btn-outline-secondary btn-sm btn-block">Voir plus de détails</a>
                            <?php if($material['disponibilite']): ?>
                                <a href="index.php?action=addToCart&id=<?= $material['id'] ?>" 
                                   class="btn btn-dark btn-sm btn-block mt-2">Ajout au panier</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
