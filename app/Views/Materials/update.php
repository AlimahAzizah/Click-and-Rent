    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #424242;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        select, 
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        .checkbox-group {
            margin-top: 10px;
        }
        .btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #1E88E5;
            color: white;
        }
        .btn-secondary {
            background-color: #757575;
            color: white;
        }
        .current-image {
            margin-bottom: 15px;
        }
        .current-image img {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
    </style>


<body>
    <h1>Modifier un matériel</h1>
    
    <div class="form-container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?action=updateMaterial" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $material['id'] ?>">
            
            <div class="form-group">
                <label for="nom">Nom du matériel *</label>
                <input type="text" id="nom" name="nom" value="<?= $material['nom'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="categorie">Catégorie *</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Sélectionner une catégorie</option>
                    <option value="Ordinateur" <?= $material['categorie'] === 'Ordinateur' ? 'selected' : '' ?>>Ordinateur</option>
                    <option value="Périphérique" <?= $material['categorie'] === 'Périphérique' ? 'selected' : '' ?>>Périphérique</option>
                    <option value="Réseau & Connectivité" <?= $material['categorie'] === 'Réseau & Connectivité' ? 'selected' : '' ?>>Réseau & Connectivité</option>
                    <option value="Stockage & Sauvegarde" <?= $material['categorie'] === 'Stockage & Sauvegarde' ? 'selected' : '' ?>>Stockage & Sauvegarde</option>
                    <option value="Imprimante & Scanner" <?= $material['categorie'] === 'Imprimante & Scanner' ? 'selected' : '' ?>>Imprimante & Scanner</option>
                    <option value="Serveur & Solution Professionnel" <?= $material['categorie'] === 'Serveur & Solution Professionnel' ? 'selected' : '' ?>>Serveur & Solution Professionnel</option>
                    <option value="Accessoire & Divers" <?= $material['categorie'] === 'Accessoire & Divers' ? 'selected' : '' ?>>Accessoire & Divers</option>
                    <option value="Matériel Audiovisuel" <?= $material['categorie'] === 'Matériel Audiovisuel' ? 'selected' : '' ?>>Matériel Audiovisuel</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="etat">État *</label>
                <select id="etat" name="etat" required>
                    <option value="">Sélectionner un état</option>
                    <option value="Neuf" <?= $material['etat'] === 'Neuf' ? 'selected' : '' ?>>Neuf</option>
                    <option value="Bon" <?= $material['etat'] === 'Bon' ? 'selected' : '' ?>>Bon</option>
                    <option value="Moyen" <?= $material['etat'] === 'Moyen' ? 'selected' : '' ?>>Moyen</option>
                    <option value="Mauvais" <?= $material['etat'] === 'Mauvais' ? 'selected' : '' ?>>Mauvais</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required><?= $material['description'] ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Photo actuelle</label>
                <div class="current-image">
                    <?php if (!empty($material['photo'])): ?>
                        <img src="<?= $material['photo'] ?>" alt="<?= $material['nom'] ?>">
                    <?php else: ?>
                        <p>Aucune photo disponible</p>
                    <?php endif; ?>
                </div>
                <label for="photo">Nouvelle photo (laisser vide pour conserver l'actuelle)</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" id="disponibilite" name="disponibilite" <?= $material['disponibilite'] ? 'checked' : '' ?>>
                <label for="disponibilite" style="display: inline;">Disponible</label>
            </div>
            
            <div class="btn-container">
                <a href="index.php?action=showAdminMaterials" class="btn btn-secondary">Annuler</a>
                <a href="index.php?action=showAdminMaterials"><button type="submit" class="btn btn-primary">Mettre à jour</button></a>
            </div>
        </form>
    </div>
</body>
</html>
