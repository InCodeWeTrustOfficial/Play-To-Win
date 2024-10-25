<?php

use App\PlayToWin\Modele\DataObject\Coach;

echo "<h2>Top coach</h2>";
/** @var Coach[] $coachs */
/** @var string $controleur  */
?>

<div class="coach-container">
    <?php foreach ($coachs as $coach): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=<?php echo $controleur; ?>&action=afficherDetail&id=<?php echo $coach->getId(); ?>">
            <div class="coach-card">
                <img src="../ressources/img/jeux/lol.png" alt="Icon" class="coach-icon">
                <div class="coach-name"><?php echo $coach->getAvatarPath(); ?></div>
                <div class="coach-name"><?php echo $coach->getPseudo(); ?></div>
                <div class="coach-description"><?php echo $coach->getBiographie(); ?></div>

            </div>
        </a>
    <?php endforeach; ?>
</div>

<br>
<div class="btn">
    <a href="../web/controleurFrontal.php?controleur=service&action=afficherFormulaireProposerService" class="btn new-service-btn">Nouveau</a>
</div>