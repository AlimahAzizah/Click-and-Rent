<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre panier</title>
    <link rel="stylesheet" href="src/css/panier.css">
</head>
<body>
    <div class="section-tableau-de-bord">
        <div class="conteneur">
            <h1 class="titre-panier">Votre panier</h1>
            <div class="contenu">
                <table class="tableau-produits">
                    <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="assets/images/inscription.png" alt="Boitier MPG MSI"> Boitier MPG MSI</td>
                            <td>
                                <input type="date" class="date-input" 
                                       value="2025-06-15" 
                                       name="start_date">
                            </td>
                            <td>
                                <input type="date" class="date-input" 
                                       value="2025-07-18" 
                                       name="end_date">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="section-reservation">
                    <p class="nombre-produits">1 Produits</p>
                    <button class="bouton-reserver">Réserver</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
