<?php if (empty($panier)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($panier as $produit): ?>
            <tr>
                <td><?= htmlspecialchars($produit['nom']) ?></td>
                <td>
                    <form method="post" action="controleurFrontal.php?controleur=servicea&action=modifierQuantite">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">
                        <input type="number" name="quantite" value="<?= htmlspecialchars($produit['quantite']) ?>" min="1">
                        <input type="submit" value="Modifier">
                    </form>
                </td>
                <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                <td><?= number_format($produit['prix'] * $produit['quantite'], 2, ',', ' ') ?> €</td>
                <td>
                    <form method="post" action="controleurFrontal.php?controleur=servicea&action=supprimerProduit">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <form method="post" action="controleurFrontal.php?controleur=servicea&ction=passerCommande">
        <input type="submit" value="Passer la commande">
    </form>
<?php endif; ?>
