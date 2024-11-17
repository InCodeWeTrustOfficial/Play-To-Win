<?php

use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;

echo '<div class="conteneur-coach">';
echo "<h2>Découvre les coachs qui pourraient te correspondre :</h2>";
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
                echo '<div class="icones-liste">';
                $jeux = (new JouerRepository())->recupererJeux($coach->getId());
                /** @var Jeu $jeu */
                foreach ($jeux as $jeu) {
                    echo '<img src="../ressources/img/jeux/'.$jeu->getCodeJeu().'.png" alt="Icon" class="coach-icon">';
                }
                echo '</div>';
                ?>


                <div class="profile-header">
                    <div class="coach-infos">
                        <img class="pp" src="../<?=$coach->getAvatarPath()?>" alt="Photo de profil"
                         onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">

                        <div class="coach-info-texte">
                            <div class="coach-name"><?php echo $coach->getPseudo(); ?></div>
                            <div class="coach-id"><?php echo $coach->getId(); ?></div>
                        </div>
                    </div>
                    <div class="coach-langs">
                        <?php
                        $langues = (new ParlerRepository())->recupererLangues($coach->getId());
                        /** @var Langue $l */
                        foreach ($langues as $l) {
                            echo '<img class="lang" src="../'.$l->getDrapeauPath().'" alt="'.$l->getCodeAlpha().'">';
                        }
                        ?>
                    </div>
                </div>

                <hr>
                <div class="coach-description"><p><?php echo $coach->getBiographie(); ?></p></div>

            </div>
        </a>
    <?php endforeach; ?>
</div>
<?php echo "</div>";?>
