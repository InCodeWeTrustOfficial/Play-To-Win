<?php

use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

echo '<div class="conteneur-coach">';
echo "<h2>Découvre les coachs qui pourraient te correspondre :</h2>";
/** @var Coach[] $coachs */
/** @var string $controleur  */

/** @var string $conf */
?>

<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='afficherListe'>
    <input type='hidden' name='controleur' value="coach">

    <select name="lang" id="lang_id">
        <?php
        /** @var boolean $avoirLangue */
        if(!$avoirLangue){
            echo '<option value="rien" selected="selected">Langue...?</option>';
        } else{
            /** @var Langue $langue */
            /** @var string $codeAlphaLanque */
            /** @var string $nomLangue */

            echo '<option value="'.$codeAlphaLanque.'" selected="selected">'.$nomLangue.'</option>';
            echo '<option value="rien">aucune</option>';
        }
        /** @var Langue[] $langues */
        /** @var string $langueRequest */

        foreach ($langues as $l) {
            if(!($avoirLangue && $l->getCodeAlpha() === $langueRequest)){
                echo '<option value="' . rawurlencode($l->getCodeAlpha()).'">' .htmlspecialchars($l->getNom()) . '</option>';
            }
        }
        ?>
    </select>
    <select name="jeu" id="jeu_id">
        <?php
        /** @var boolean $avoirJeu */
        /** @var Jeu[] $jeux */

        if(!$avoirJeu){
            echo '<option value="rien" selected="selected">Jeu...?</option>';
        } else{
            /** @var Jeu $jeu */
            /** @var string $codeJeu */
            /** @var string $nomJeu */

            echo '<option value="'.$codeJeu.'" selected="selected">'.$nomJeu.'</option>';
            echo '<option value="rien">aucun</option>';
        }

        /** @var string $jeuRequest */

        foreach ($jeux as $j) {
            if (!($avoirJeu && $j->getCodeJeu() === $jeuRequest)) {
                echo '<option value="' . rawurlencode($j->getCodeJeu()) . '">' .htmlspecialchars($j->getNomJeu()) . '</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Envoyer">
</form>

<div class="coach-container">
    <?php foreach ($coachs as $coach): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id=<?=rawurlencode($coach->getId()); ?>">
            <div class="coach-card">

                <div class="coach-banner">
                    <img src="../<?=$coach->getBannierePath()?>" alt="Banner" class="banner-image"
                         onerror="this.onerror=null; this.src='../ressources/img/defaut_banniere.png';">
                </div>

                <?php
                echo '<div class="icones-liste">';
                /** @var Jeu $jeu */
                $jeuxJoues = (new JouerRepository())->recupererJeux($coach->getId());
                foreach ($jeuxJoues as $jeu) {
                    echo '<img src="../ressources/img/jeux/'.$jeu->getCodeJeu().'.png" alt="Icon" class="coach-icon">';
                }
                echo '</div>';
                ?>


                <div class="profile-header">
                    <div class="coach-infos">
                        <img class="pp" src="../<?=$coach->getAvatarPath()?>" alt="Photo de profil"
                         onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">

                        <div class="coach-info-texte">
                            <div class="coach-name"><?php echo htmlspecialchars($coach->getPseudo()); ?></div>
                            <div class="coach-id"><?php echo htmlspecialchars($coach->getId()); ?></div>
                        </div>
                    </div>
                    <div class="coach-langs">
                        <?php
                        // Je ne sais pas comment le retirer
                        $languesParlees = (new ParlerRepository())->recupererLangues($coach->getId());
                        /** @var Langue $l */
                        foreach ($languesParlees as $l) {
                            echo '<img class="lang" src="../'.$l->getDrapeauPath().'" alt="'.htmlspecialchars($l->getCodeAlpha()).'">';
                        }
                        ?>
                    </div>
                </div>

                <hr>
                <div class="coach-description"><p><?php echo htmlspecialchars($coach->getBiographie()); ?></p></div>

            </div>
        </a>
    <?php endforeach; ?>
</div>
<?php echo "</div>";?>
