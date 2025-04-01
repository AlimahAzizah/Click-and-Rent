<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
    <link rel="stylesheet" href="src/css/boutique.css">
</head>
<body>
<main>
    <?php require_once __DIR__ . '/../../Models/Material.php';

    $model = new Material();
    $materials = $model->readAll();

    ?>
    <h1>Nos Produits</h1>
    <section class="products-grid">
    <?php foreach ($materials as $material): ?>
            <a href="index.php?action=showMaterialDetails&id=<?= $material['id'] ?>" class="btn-details">
            <div class="product-card">
                <?php if (!empty($material['photo'])): ?>
                    <img src="<?= $material['photo'] ?>" alt="<?= $material['nom'] ?>" class="product-image">
                <?php else: ?>
                    <img src="public/assets/images/no-image.png" alt="Pas d'image" class="product-image">
                <?php endif; ?>
                <div class="product-info">
                    <div class="product-name"><?= $material['nom'] ?></div>
                    <div class="material-status">
                        <?php if ($material['disponibilite']): ?>
                            <span class="product-available">Disponible</span>
                        <?php else: ?>
                            <span class="product-unavailable">Indisponible</span>
                        <?php endif; ?>
                    </div>
                    <br>
                    <div class="material-actions">
                        <?php if ($material['disponibilite']): ?>
                            <a href="index.php?action=addToCart&id=<?= $material['id'] ?>" class="btn-add"><button class="add-to-cart">Ajouter au panier</button></a>
                        <?php else: ?>
                            <button class="add-to-cart">Ajouter au panier</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            </a>
        <?php endforeach; ?>
        
    </section>
</main>
</body>
</html>