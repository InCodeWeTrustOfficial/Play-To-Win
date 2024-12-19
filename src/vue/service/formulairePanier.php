<?php

/** @var string $conf */
/* @var float $totalprix */
/** @var array $panier */

if (empty($panier)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <form method="<?=$conf?>" action="controleurFrontal.php" id="PanierForm">
        <input type='hidden' name='action' value='passerCommande'>
        <input type='hidden' name='controleur' id="controleur" value='commande'>
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
            <?php foreach ($panier as $produit):
                for ($i = 0; $i < $produit['quantite']; $i++): ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nom']) ?></td>
                        <td><?= htmlspecialchars($produit['typeService']) ?></td>
                        <td>
                            <input type="text"
                                   id="sujet"
                                   name="sujet[<?= rawurlencode($produit['id']) ?>][]"
                                   placeholder="Ex : entrainement au kickoff"
                                   required>
                        </td>
                        <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endfor;
            endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <strong>Total Commande :</strong> <?= number_format($totalprix, 2, ',', ' ') ?> €
        </div>

        <input type="submit" value="Passer la commande">
    </form>
<?php endif; ?>