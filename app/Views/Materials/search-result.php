    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1, h2 {
            color: #424242;
        }
        .search-container {
            margin-bottom: 30px;
        }
        .search-form {
            display: flex;
            max-width: 600px;
        }
        .search-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #1E88E5;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-size: 16px;
        }
        .search-results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .material-card {
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 10px;
            border: 1px solid #eee;
        }
        .material-image {
            height: 150px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: 1px solid #eee;
            margin-bottom: 10px;
        }
        .material-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .material-info {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .material-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 10px 0;
            text-align: center;
        }
        .material-status {
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }
        .status-available {
            color: #4CAF50;
        }
        .status-unavailable {
            color: #F44336;
        }
        .material-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: auto;
        }
        .btn-details {
            display: block;
            text-align: center;
            padding: 8px 0;
            border: 1px solid #1E88E5;
            border-radius: 4px;
            color: #1E88E5;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-add {
            display: block;
            text-align: center;
            padding: 8px 0;
            background-color: black;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-add:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .no-results {
            text-align: center;
            padding: 30px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>


<body>
    <h1>Résultats de recherche</h1>
    
    <div class="search-container">
        <form action="index.php?action=searchMaterials" method="GET" class="search-form">
            <input type="hidden" name="action" value="searchMaterials">
            <input type="text" name="query" class="search-input" placeholder="Rechercher un matériel..." value="<?= isset($query) ? htmlspecialchars($query) : '' ?>">
            <button type="submit" class="search-button">Rechercher</button>
        </form>
    </div>
    
    <?php if (!empty($query)): ?>
        <h2>Résultats pour "<?= htmlspecialchars($query) ?>"</h2>
    <?php endif; ?>
    
    <?php if (empty($materials)): ?>
        <div class="no-results">
            <p>Aucun matériel ne correspond à votre recherche.</p>
        </div>
    <?php else: ?>
        <div class="search-results">
            <?php foreach ($materials as $material): ?>
                <div class="material-card">
                    <div class="material-image">
                        <?php if (!empty($material['photo'])): ?>
                            <img src="<?= $material['photo'] ?>" alt="<?= $material['nom'] ?>">
                        <?php else: ?>
                            <img src="public/assets/images/no-image.png" alt="Pas d'image">
                        <?php endif; ?>
                    </div>
                    <div class="material-info">
                        <h3 class="material-title"><?= $material['nom'] ?></h3>
                        <div class="material-status">
                            <?php if ($material['disponibilite']): ?>
                                <span class="status-available">Disponible</span>
                            <?php else: ?>
                                <span class="status-unavailable">Indisponible</span>
                            <?php endif; ?>
                        </div>
                        <div class="material-actions">
                            <a href="index.php?action=showMaterialDetails&id=<?= $material['id'] ?>" class="btn-details">Voir plus de détails</a>
                            <?php if ($material['disponibilite']): ?>
                                <a href="index.php?action=addToCart&id=<?= $material['id'] ?>" class="btn-add">Ajout au panier</a>
                            <?php else: ?>
                                <button class="btn-add" disabled>Ajout au panier</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
