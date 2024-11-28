<?php
use App\PlayToWin\Modele\DataObject\Commande;

/** @var Commande[] $commandes */
/** @var string $controleur  */
?>

<div class="commandes-container">
    <h2 class="commandes-title">Liste des commandes passées</h2>
    <?php if (empty($commandes)): ?>
        <div class="no-commandes">
            Aucune commande n'a été passées pour le moment.
        </div>
    <?php else: ?>
        <?php foreach ($commandes as $commande): ?>
            <a class="commande-link" href="../web/controleurFrontal.php?controleur=exemplaireservice&action=afficherListe&idcommande=<?= htmlspecialchars($commande->getIdCommande()) ?>">
                <div class="commande-card">
                    <div class="commande-info">
                        <div class="commande-id">
                            Commande #<?= htmlspecialchars($commande->getIdCommande()) ?>
                        </div>
                        <div class="commande-date">
                            <?= $commande->getDateAchat()->format('d/m/Y à H:i') ?>
                        </div>
                        <div class="commande-prix">
                            Prix total : <?= number_format($commande->getPrixTotal(), 2) ?> €
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>