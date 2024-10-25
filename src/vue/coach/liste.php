<?php

use App\PlayToWin\Modele\DataObject\Coach;

echo "<h2>Top coach</h2>";
/** @var Coach[] $coachs */
/** @var string $controleur  */
?>

<div class="coach-container">
    <?php foreach ($coachs as $coach): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=service&action=afficherListe&id=<?php echo $coach->getId(); ?>">
            <div class="coach-card">

                <div class="coach-banner">
                    <img src="../ressources/img/uploads/coach/bannieres/Yota002.png" alt="Banner" class="banner-image">
                </div>

                <img src="../ressources/img/jeux/lol.png" alt="Icon" class="coach-icon">

                <img src="../'.$utilisateur->getAvatarPath().'" alt="Photo de profil" style="width: 70px; height: 70px; object-fit: cover;"
                     onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">

                <div class="coach-name"><?php echo $coach->getPseudo(); ?></div>
                <hr>
                <div class="coach-description"><?php echo $coach->getBiographie(); ?></div>

            </div>
        </a>
    <?php endforeach; ?>
</div>