<?php
use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Lib\GestionPanier;

$panier = GestionPanier::getPanier();
if (empty($panier)): ?>
    <div class="empty-cart-message">
        <p>Votre panier est vide.</p>
        <p>Ajoutez des produits à votre panier pour passer commande.</p>
    </div>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($panier as $produit): ?>
            <tr>
                <td><?= htmlspecialchars($produit['nom']) ?></td>
                <td>
                    <form method="<?= ConfigurationSite::getDebug() ? 'get' : 'post' ?>" action="controleurFrontal.php?controleur=service&action=modifierQuantite&codeService=<?= htmlspecialchars($produit['id']) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">
                        <input type="number" name="quantite" value="<?= htmlspecialchars($produit['quantite']) ?>" min="1">
                        <input type="submit" value="Modifier">
                    </form>
                </td>
                <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                <td>
                    <form method="<?= ConfigurationSite::getDebug() ? 'get' : 'post' ?>" action="controleurFrontal.php?controleur=service&action=supprimerProduit&codeService=<?= rawurlencode($produit['id']) ?>">
                        <input type="hidden" name="id" value="<?= rawurlencode($produit['id']) ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <strong>Total Commande :</strong> <?= number_format(GestionPanier::getTotalPrix(), 2, ',', ' ') ?> €
    </div>

    <form method="<?= ConfigurationSite::getDebug() ? 'get' : 'post' ?>" action="controleurFrontal.php?controleur=commande&action=afficherFormulairePanier">
        <input type="submit" value="Passer la commande">
    </form>
<?php endif; ?>
