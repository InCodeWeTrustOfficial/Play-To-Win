<?php
/** @var Coach $coach */


use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;

$idURL = rawurlencode($coach->getId());
$idHTML = htmlspecialchars($coach->getId());
$nomHTML = htmlspecialchars($coach->getNom());
$prenomHTML = htmlspecialchars($coach->getPrenom());
$pseudoHTML = htmlspecialchars($coach->getPseudo());
$emailHTML = htmlspecialchars($coach->getEmail());
$biographieHTML = htmlspecialchars($coach->getBiographie());
$dateNaissanceHTML = htmlspecialchars($coach->getDateNaissance()->format("d/m/Y"));
$avatarHTML = htmlspecialchars($coach->getAvatarPath());

$bonUtilisateur = ConnexionUtilisateur::estUtilisateur($coach->getId()) || ConnexionUtilisateur::estAdministrateur();
?>

    <div class="conteneur-listecoach">
        <div class="conteneur-listeinfo">
            <div class="coach-langs">
                <?php
                $langues = (new ParlerRepository())->recupererLangues($coach->getId());
                /** @var Langue $l */
                foreach ($langues as $l) {
                    echo '<img class="lang" src="../'.$l->getDrapeauPath().'" alt="'.$l->getCodeAlpha().'">';
                }
                ?>
            </div>
            <div class="banniereCustom">
                <?php if($bonUtilisateur) echo '<a class="changementBann" href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireBanniere&id=' . $idURL . '"></a>';?>
                <img class="bann" src="../<?= $coach->getBannierePath() ?>" alt="Bannière"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_banniere.png';">

            </div>
            <img class="ppcoach" src="../<?=$avatarHTML?>" alt="Photo de profil"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
            <div class="noms">
                <h3><?= $pseudoHTML ?></h3>
                <h4><?= $idHTML ?></h4>
                <?php
                if($bonUtilisateur){echo '<a href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireMiseAJour&id=' . $idURL . '">M</a>';}
                ?>
            </div>
            <p class="bio"><?=$biographieHTML?></p>
            <p class="contact"><?=$emailHTML?></p>
        </div>
        <a class="buttonCoach" href="../web/controleurFrontal.php?controleur=service&action=afficherListe&id=<?php echo $coach->getId(); ?>">Voir les services de <?=$pseudoHTML?></a>
        <?php
        if ($bonUtilisateur) {
            echo '<a class="buttonCoach" id="desinc" href = "../web/controleurFrontal.php?controleur=coach&action=supprimer&id=' . $idURL . '">Se désinscrire de la liste des coachs !</a>';
        }
        ?>
    </div>


