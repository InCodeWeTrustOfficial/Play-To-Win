<?php
/** @var Coach $coach */


use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;

/** @var string $idURLL */
/** @var string $idHTML */
/** @var string $prenomHTML */
/** @var string $pseudoHTML */
/** @var string $emailHTML */
/** @var string $biographieHTML */
/** @var string $dateNaissanceHTML */
/** @var string $avatarHTML */
/** @var string $bannierePath */

/** @var boolean $bonUtilisateur */

/** @var Langue[] $langues */
?>

    <div class="conteneur-listecoach">
        <div class="conteneur-listeinfo">
            <div class="coach-langs">
                <?php
                /** @var Langue $l */
                foreach ($langues as $l) {
                    echo '<img class="lang" src="../'.$l->getDrapeauPath().'" alt="'. htmlspecialchars($l->getCodeAlpha()).'">';
                }
                ?>
            </div>
            <div class="banniereCustom">
                <?php if($bonUtilisateur) echo '<a class="changementBann" href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireBanniere&id=' . $idURLL . '"></a>';?>
                <img class="bann" src="../<?= $bannierePath ?>" alt="Bannière"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_banniere.png';">

            </div>
            <img class="ppcoach" src="../<?=$avatarHTML?>" alt="Photo de profil"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
            <div class="noms">
                <h3><?= $pseudoHTML ?></h3>
                <h4><?= $idHTML ?></h4>
                <?php
                if($bonUtilisateur){echo '<a href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireMiseAJour&id=' . $idURLL . '"><img src="../ressources/img/icone/crayon.png"></a>';}
                ?>
            </div>
            <p class="bio"><?=$biographieHTML?></p>
            <p class="contact"><?=$emailHTML?></p>
        </div>
        <a class="buttonCoach" href="../web/controleurFrontal.php?controleur=service&action=afficherListe&id=<?php echo $idURLL ?>">Consulter les services de <?=$pseudoHTML?></a>
        <?php
        if ($bonUtilisateur) {
            echo '<a class="buttonCoach" id="desinc" href = "../web/controleurFrontal.php?controleur=coach&action=supprimer&id=' . $idURLL . '">Se désinscrire de la liste des coachs !</a>';
        }
        ?>
    </div>


