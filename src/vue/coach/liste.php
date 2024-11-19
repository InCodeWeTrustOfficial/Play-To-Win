<?php

use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\LangueRepository;

echo '<div class="conteneur-coach">';
echo "<h2>Découvre les coachs qui pourraient te correspondre :</h2>";
/** @var Coach[] $coachs */
/** @var string $controleur  */
?>

<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='afficherListe'>
    <input type='hidden' name='controleur' value="coach">

    <select name="lang" id="lang_id">
        <?php
        if(!isset($_REQUEST['lang']) || $_REQUEST['lang'] === "rien"){
            echo '<option value="rien" selected="selected">Langue...?</option>';
        } else{
            /** @var Langue $langue */
            $langue = (new LangueRepository())->recupererParClePrimaire($_REQUEST['lang']);
            echo '<option value="'.$langue->getCodeAlpha().'" selected="selected">'.$langue->getNom().'</option>';
            echo '<option value="rien">aucune</option>';
        }
        $langues = (new LangueRepository())->recuperer();

        foreach ($langues as $l) {
            /** @var Langue $l */
            if(!(isset($_REQUEST['lang']) && $l->getCodeAlpha() === $_REQUEST['lang'])){
                echo '<option value="' . $l->getCodeAlpha().'">' . $l->getNom() . '</option>';
            }
        }
        ?>
    </select>
    <select name="jeu" id="jeu_id">
        <?php

        if(!isset($_REQUEST['jeu']) || $_REQUEST['jeu'] === "rien"){
            echo '<option value="rien" selected="selected">Jeu...?</option>';
        } else{
            /** @var Jeu $jeu */
            $jeu = (new JeuRepository())->recupererParClePrimaire($_REQUEST['jeu']);
            echo '<option value="'.$jeu->getCodeJeu().'" selected="selected">'.$jeu->getNomJeu().'</option>';
            echo '<option value="rien">aucun</option>';
        }

        $jeux = (new JeuRepository())->recuperer();

        foreach ($jeux as $j) {
            /** @var Jeu $j */
            if (!(isset($_REQUEST['jeu']) && $j->getCodeJeu() === $_REQUEST['jeu'])) {
                echo '<option value="' . $j->getCodeJeu() . '">' . $j->getNomJeu() . '</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Envoyer">
</form>

<div class="coach-container">
    <?php foreach ($coachs as $coach): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id=<?php echo $coach->getId(); ?>">
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
