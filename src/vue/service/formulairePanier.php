<?php if (empty($panier)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Type produit</th>
            <th>Sujet</th>
            <th>Prix Unitaire</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalGlobal = 0;
        foreach ($panier as $produit):
            $sousTotal = $produit['prix'] * $produit['quantite'];
            $totalGlobal += $sousTotal;
            for ($i = 0; $i < $produit['quantite']; $i++): ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nom']) ?></td>
                    <td><?= htmlspecialchars($produit['type']) ?></td>
                    <td>
                        <textarea name="sujets[<?= htmlspecialchars($produit['id']) ?>][]" placeholder="Ex : entrainement au kickoff" rows="2" cols="20" required></textarea>
                    </td>
                    <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                </tr>
            <?php endfor; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <strong>Total Commande :</strong> <?= number_format($totalGlobal, 2, ',', ' ') ?> €
    </div>

    <form method="post" action="controleurFrontal.php?controleur=commande&action=passerCommande">
        <input type="submit" value="Passer la commande">
    </form>
<?php endif; ?>
