<?php

use App\PlayToWin\Modele\DataObject\Services;

echo "<h2>Liste des services proposé</h2>";
/** @var Services[] $services */
/** @var string $controleur  */
?>

<div class="service-container">
    <?php foreach ($services as $service): ?>
    <a class="detail-link" href="../web/controleurFrontal.php?controleur=<?php echo $controleur; ?>&action=afficherDetail&codeService=<?php echo $service->getCodeService(); ?>">

    <div class="service-card">
             <img src="../ressources/img/jeux/lol.png" alt="Icon" class="service-icon">
            <div class="service-name"><?php echo $service->getNomService(); ?></div>
            <div class="service-description"><?php echo $service->getDescriptionService(); ?></div>
            <div class="service-coach">Coach ID: <?php echo $service->getCoach(); ?></div>
            <div class="service-game">Jeu: <?php echo $service->getNomJeu(); ?></div>
            <div class="service-price"><?php echo number_format($service->getPrixService(), 2); ?> €</div>
        </div>
    </a>
    <?php endforeach; ?>
</div>

<br>
<h3>
    Lien pour créer un services :
    <a href="controleurFrontal.php?controleur=service&action=afficherFormulaireProposerService">Création</a>
</h3>
