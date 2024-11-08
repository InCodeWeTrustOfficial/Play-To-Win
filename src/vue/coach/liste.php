<?php

use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;

echo "<h2>Top coach</h2>";
/** @var Coach[] $coachs */
/** @var string $controleur  */
?>

<div class="coach-container">
    <?php foreach ($coachs as $coach): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=service&action=afficherListe&id=<?php echo $coach->getId(); ?>">
            <div class="coach-card">

                <div class="coach-banner">
                    <img src="../<?=$coach->getBannierePath()?>" alt="Banner" class="banner-image"
                         onerror="this.onerror=null; this.src='../ressources/img/defaut_banniere.png';">
                </div>

                <?php
                $jeux = (new JouerRepository())->recupererJeux($coach->getId());
                /** @var Jeu $jeu */
                foreach ($jeux as $jeu) {
                    echo '<img src="../ressources/img/jeux/'.$jeu->getCodeJeu().'.png" alt="Icon" class="coach-icon">';
                }
                ?>

                <div class="profile-header">
                    <img src="../<?=$coach->getAvatarPath()?>" alt="Photo de profil"
                         onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
                    <div class="coach-name"><?php echo $coach->getPseudo(); ?></div>
                </div>

                <hr>
                <div class="coach-description"><?php echo $coach->getBiographie(); ?></div>

            </div>
        </a>
    <?php endforeach; ?>
</div>
