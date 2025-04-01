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
    </style>

<body>
    <h1>Ajouter un nouveau matériel</h1>
    
    <div class="form-container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?action=createMaterial" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom">Nom du matériel *</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            
            <div class="form-group">
                <label for="categorie">Catégorie *</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Sélectionner une catégorie</option>
                    <option value="Ordinateur">Ordinateur</option>
                    <option value="Périphérique">Périphérique</option>
                    <option value="Réseau & Connectivité">Réseau & Connectivité</option>
                    <option value="Stockage & Sauvegarde">Stockage & Sauvegarde</option>
                    <option value="Imprimante & Scanner">Imprimante & Scanner</option>
                    <option value="Serveur & Solution Professionnel">Serveur & Solution Professionnel</option>
                    <option value="Accessoire & Divers">Accessoire & Divers</option>
                    <option value="Matériel Audiovisuel">Matériel Audiovisuel</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="etat">État *</label>
                <select id="etat" name="etat" required>
                    <option value="">Sélectionner un état</option>
                    <option value="Neuf">Neuf</option>
                    <option value="Bon">Bon</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Mauvais">Mauvais</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" id="disponibilite" name="disponibilite" checked>
                <label for="disponibilite" style="display: inline;">Disponible</label>
            </div>
            
            <div class="btn-container">
                <a href="index.php?action=showAdminMaterials" class="btn btn-secondary">Annuler</a>
                <a href="index.php?action=showAdminMaterials"><button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>
