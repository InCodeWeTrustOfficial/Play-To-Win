<?php
/** @var Utilisateur $utilisateur */

use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\SeClasserRepository;

/** @var string $idURLL */
/** @var string $idHTML */
/** @var string $nomHTML */
/** @var string $prenomHTML */
/** @var string $pseudoHTML */
/** @var string $dateNaissanceHTML */
/** @var string $emailHTML */
/** @var string $avatarHTML */

/** @var array $langues */
/** @var array $jouer */

/** @var boolean $aValideEmail */
/** @var boolean $estAdmin */
/** @var boolean $estBonUtilisateur */
/** @var boolean $estCoachh */

/** @var string $avatarPath */
/** @var string $emailAValider */

?>

<div class="utilisateurDetail-conteneur">

    <?php if(!$aValideEmail): ?>
    <div class="user-email">
        <h2><?php echo "Vous devez valider l'email suivante : ".$emailAValider?></h2>
    </div>
    <?php endif; ?>

    <?php if($aValideEmail): ?>
    <div class="user-main-conteneur <?php if ($estAdmin) echo 'admin'?>">
        <div class ="avatar-conteneur">
            <img class="ppUser" src="../<?=$avatarPath?>" alt="Photo de profil"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
            <?php if($estBonUtilisateur):?>
            <div class="modifAvatar">
                <a href="../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireAvatar&id=<?=$idURLL?>"></a>
            </div>
            <?php endif;?>
        </div>

        <div class="infos-generales">
            <div class="basiques">
                <p>idURL : <?= $idURLL?></p>
                <p>id : <?= $idHTML ?></p>
                <p>Nom : <?= $nomHTML ?></p>
                <p>Prenom : <?= $prenomHTML ?></p>
                <p>Pseudo : <?= $pseudoHTML ?></p>
                <p>Email : <?= $emailHTML ?></p>
                <p>Date de naissance : <?= $dateNaissanceHTML ?></p>
            </div>
            <div class="specifiques">
                <div class="langues-utilisateur">
                    <?php
                    if ($langues === null) {
                        echo '<p>Aucune langue enregistrée.</p>';
                    } else{
                        /** @var Langue $l */
                        foreach ($langues as $l){
                            echo '<p class="langu"><img src="../'.$l->getDrapeauPath().'" alt="Drapeau">';
                            if($estBonUtilisateur){
                                echo '<a href="../web/controleurFrontal.php?controleur=langue&action=supprimerLangue&id=' . $idURLL . '&lang='.$l->getCodeAlpha().'">X</a>';
                            }
                            echo '</p>';
                        }
                    }
                    ?>
                    <?php if($estBonUtilisateur):?>
                    <a href="../web/controleurFrontal.php?controleur=langue&action=afficherFormulaireAjout&id=<?=$idURLL?>">Nouvelle langue ?</a>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <a class="jeux-utilisateur">
            <?php
            if($jouer === null){
                echo '<p>Aucun jeu</p>';
            } else{
                foreach ($jouer as $ligne){
                    /** @var ClassementJeu $classJeu */
                    // Je ne vois pas comment ne pas faire un appel à seClasserRepository.
                    $classJeu = (new SeClasserRepository())->recupererDepuisJouer($ligne);
                    $modeHTML = htmlspecialchars($ligne[1]->getNomMode());
                    $modeURL = rawurlencode($ligne[1]->getNomMode());
                    echo '<p class="ligne-jeu">';
                    if($estBonUtilisateur){
                          echo '<a href="../web/controleurFrontal.php?controleur=jouer&action=afficherModifJouer&id=' . $idURLL . '&jeu='.$ligne[0]->getCodeJeu().'&mode='.$modeURL.'">';
                    }
                              echo '<small>'.$modeHTML.'</small>
                                    <img src="../'.$ligne[0]->getPathLogo().'" alt="'.htmlspecialchars($ligne[0]->getNomJeu()).'">
                                    <img class="classement" src="../'.$classJeu->getClassPath().'" alt="Classement">';
                    if($estBonUtilisateur){
                        echo '</a><a href="../web/controleurFrontal.php?controleur=jouer&action=supprimerJouer&id=' . $idURLL . '&jeu='.$ligne[0]->getCodeJeu().'&mode='.$modeURL.'">X</a>';
                    }
                }
            }
            ?>
            <?="</p>"?>
            <?php if($estBonUtilisateur):?>
            <a class="nouveauJeu" href="../web/controleurFrontal.php?controleur=jouer&action=afficherFormulaireJouer&id=<?=$idURLL?>">Nouveau jeu?</a>
            <?php endif; ?>

        </div>
        <?php
        if($estBonUtilisateur){
            echo '<div class="lienMAJ">';
            echo '    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&id='.$idURLL.'">Modifier des informations ?</a>';
            echo '    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=supprimer&id=' . $idURLL . '">Supprimer le compte</a>';
            echo '</div>';
        }
        ?>

    <?php endif; ?>
    <div class="devCoach">
        <?php if($estCoachh):?>
        <a href = "../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id=<?=$idURLL?>">voir la page coach</a>
        <?php endif;?>
        <?php if(!$estCoachh):?>
        <a href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireCreation&id=<?=$idURLL?>">je souhaite devenir coach...</a>
        <?php endif;?>
    </div>
</div>
</div>
