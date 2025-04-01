    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .breadcrumb {
            padding: 15px 20px;
            background-color: #f1f1f1;
        }
        .breadcrumb a {
            color: #1E88E5;
            text-decoration: none;
        }
        .breadcrumb span {
            margin: 0 5px;
        }
        .material-details {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }
        .material-image {
            flex: 0 0 400px;
            margin-right: 30px;
            margin-bottom: 20px;
        }
        .material-image img {
            max-width: 100%;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .material-info {
            flex: 1;
            min-width: 300px;
        }
        .material-name {
            font-size: 24px;
            margin: 0 0 15px 0;
            color: #212121;
        }
        .material-status {
            display: inline-block;
            margin-bottom: 20px;
            padding: 5px 15px;
            border-radius: 15px;
            font-weight: bold;
        }
        .status-available {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .status-unavailable {
            background-color: #ffebee;
            color: #c62828;
        }
        .material-category,
        .material-condition {
            margin-bottom: 10px;
            color: #757575;
        }
        .material-category strong,
        .material-condition strong {
            color: #212121;
        }
        .material-description {
            margin-top: 30px;
        }
        .description-title {
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .description-content {
            line-height: 1.6;
            color: #424242;
        }
        .actions {
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            margin-right: 10px;
        }
        .btn-primary {
            background-color: black;
            color: white;
        }
        .btn-secondary {
            border: 1px solid #1E88E5;
            color: #1E88E5;
        }
    </style>

<body>
    <div class="container">

        <div class="breadcrumb">
            <a href="index.php?action=getMaterialsCatalogue">Catalogue</a>
            <span>></span>
            <?= $material['nom'] ?>
        </div>
        
        <div class="material-details">
            <div class="material-image">
                <?php if (!empty($material['photo'])): ?>
                    <img src="<?= $material['photo'] ?>" alt="<?= $material['nom'] ?>">
                <?php else: ?>
                    <img src="public/assets/images/no-image.png" alt="Pas d'image">
                <?php endif; ?>
            </div>
            
            <div class="material-info">
                <h1 class="material-name"><?= $material['nom'] ?></h1>
                
                <?php if ($material['disponibilite']): ?>
                    <div class="material-status status-available">Disponible</div>
                <?php else: ?>
                    <div class="material-status status-unavailable">Indisponible</div>
                <?php endif; ?>
                
                <div class="material-category">
                    <strong>Catégorie:</strong> <?= $material['categorie'] ?>
                </div>
                
                <div class="material-condition">
                    <strong>État:</strong> <?= $material['etat'] ?>
                </div>
                
                <div class="actions">
                    <?php if ($material['disponibilite']): ?>
                        <a href="index.php?action=addToCart&id=<?= $material['id'] ?>" class="btn btn-primary">Ajouter au panier</a>
                    <?php else: ?>
                        <button class="btn btn-primary" disabled>Indisponible</button>
                    <?php endif; ?>
                    <a href="index.php?action=getMaterialsCatalogue" class="btn btn-secondary">Retour au catalogue</a>
                </div>
            </div>
            
            <div class="material-description">
                <h2 class="description-title">Description</h2>
                <div class="description-content">
                    <p><?= nl2br($material['description']) ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
