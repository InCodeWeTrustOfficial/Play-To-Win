<?php

use App\PlayToWin\Modele\DataObject\Commande;

echo "<h2>Liste des Commande effectuer</h2>";
/** @var Commande[] $commandes */
/** @var string $controleur  */
?>

<?php foreach ($commandes as $commande): ?>
    <a  href="../web/controleurFrontal.php?controleur=exemplaireservice&action=afficherListe&idcommande=<?php echo $commande->getIdCommande(); ?>">
        <div>
            <?php echo $commande->getIdCommande(); ?>
            <?php echo $commande->getDateAchat()->format('Y-m-d H:i:s'); ?>
        </div>
    </a>
<?php endforeach; ?>