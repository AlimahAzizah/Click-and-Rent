<?php
require_once __DIR__ . '/../../Models/Material.php';
$materialModel = new Material();

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<section class="section-tableau-de-bord">
    <link rel="stylesheet" href="src/css/panier.css">
    <div class="conteneur">
        <h1 class="titre-panier">Votre panier</h1>
        
        <div class="contenu">
            <div class="tableau-wrapper">
                <table class="tableau-produits">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Nom du produit</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($_SESSION['cart'])): 
                            $totalItems = 0;
                            foreach ($_SESSION['cart'] as $materialId):
                                if ($materialModel->readById($materialId) && $materialModel->getDisponibilite()):
                                    $totalItems++; ?>
                                    <tr>
                                        <td>
                                            <?php if ($materialModel->getPhoto()): ?>
                                                <img src="<?= htmlspecialchars($materialModel->getPhoto()) ?>" 
                                                     alt="<?= htmlspecialchars($materialModel->getNom()) ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($materialModel->getNom()) ?></td>
                                        <td>
                                            <input type="date" 
                                                   class="date-input" 
                                                   name="date_debut[<?= $materialId ?>]"
                                                   min="<?= date('Y-m-d') ?>">
                                        </td>
                                        <td>
                                            <input type="date" 
                                                   class="date-input" 
                                                   name="date_fin[<?= $materialId ?>]"
                                                   min="<?= date('Y-m-d') ?>">
                                        </td>
                                    </tr>
                                <?php else: 
                                    // Remove unavailable items from cart
                                    unset($_SESSION['cart'][array_search($materialId, $_SESSION['cart'])]);
                                    $_SESSION['error'] = "Un ou plusieurs articles n'étaient plus disponibles";
                                endif;
                            endforeach; 
                        endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="section-reservation">
                <div class="nombre-produits">
                    <?= ($totalItems ?? 0) ?> Produit<?= ($totalItems != 1) ? 's' : '' ?>
                </div>
                <form action="index.php?action=submitLoanRequest" method="POST">
                    <button type="submit" class="bouton-reserver">Réserver</button>
                </form>
            </div>
        </div>
    </div>
</section>
