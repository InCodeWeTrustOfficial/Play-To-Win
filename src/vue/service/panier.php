<?php
if (empty($panier)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Total</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalGlobal = 0;
        foreach ($panier as $produit):
            $sousTotal = $produit['prix'] * $produit['quantite'];
            $totalGlobal += $sousTotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($produit['nom']) ?></td>
                <td>
                    <form method="post" action="controleurFrontal.php?controleur=service&action=modifierQuantite&codeService=<?= htmlspecialchars($produit['id']) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">
                        <input type="number" name="quantite" value="<?= htmlspecialchars($produit['quantite']) ?>" min="1">
                        <input type="submit" value="Modifier">
                    </form>
                </td>
                <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                <td><?= number_format($sousTotal, 2, ',', ' ') ?> €</td>
                <td>
                    <form method="post" action="controleurFrontal.php?controleur=service&action=supprimerProduit&codeService=<?= htmlspecialchars($produit['id']) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <strong>Total Commande :</strong> <?= number_format($totalGlobal, 2, ',', ' ') ?> €
    </div>

    <form method="post" action="controleurFrontal.php?controleur=commande&action=afficherFormulairePanier">
        <input type="submit" value="Passer la commande">
    </form>
<?php endif; ?>
