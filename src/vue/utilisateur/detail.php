<?php
/** @var Utilisateur $utilisateur */

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Association\SeClasserRepository;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;

$idURL = rawurlencode($utilisateur->getId());

$idHTML = htmlspecialchars($utilisateur->getId());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
$pseudoHTML = htmlspecialchars($utilisateur->getPseudo());
$dateNaissanceHTML = htmlspecialchars($utilisateur->getDateNaissance()->format("d/m/Y"));
$emailHTML = htmlspecialchars($utilisateur->getEmail());
$avatarHTML = htmlspecialchars($utilisateur->getAvatarPath());

$langues = (new ParlerRepository())->recupererLangues($utilisateur->getId());
$jouer = (new JouerRepository())->recupererModeJeuClassement($utilisateur->getId());

$aValideEmail = $utilisateur->getEmail() !== "";
$estAdmin = ConnexionUtilisateur::estAdministrateur();
$estBonUtilisateur = $estAdmin || (ConnexionUtilisateur::estConnecte() && ConnexionUtilisateur::estUtilisateur($utilisateur->getId()));
$estCoach = (new CoachRepository())->estCoach($utilisateur->getId());
?>

<div class="utilisateurDetail-conteneur">

    <?php if(!$aValideEmail): ?>
    <div class="user-email">
        <h2><?php echo "Vous devez valider l'email suivante : ".htmlspecialchars($utilisateur->getEmailAValider());?></h2>
    </div>
    <?php endif; ?>

    <?php if($aValideEmail): ?>
    <div class="user-main-conteneur <?php if ($estAdmin) echo 'admin'?>">
        <div class ="avatar-conteneur">
            <img class="ppUser" src="../<?=$utilisateur->getAvatarPath()?>" alt="Photo de profil"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
            <?php if($estBonUtilisateur):?>
            <div class="modifAvatar">
                <a href="../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireAvatar&id=<?=$idURL?>"></a>
            </div>
            <?php endif;?>
        </div>

        <div class="infos-generales">
            <div class="basiques">
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
                                echo '<a href="../web/controleurFrontal.php?controleur=langue&action=supprimerLangue&id=' . $idURL . '&lang='.$l->getCodeAlpha().'">X</a>';
                            }
                            echo '</p>';
                        }
                    }
                    ?>
                    <?php if($estBonUtilisateur):?>
                    <a href="../web/controleurFrontal.php?controleur=langue&action=afficherFormulaireAjout&id=<?=$idURL?>">Nouvelle langue ?</a>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="jeux-utilisateur">
            <?php
            if($jouer === null){
                echo '<p>Aucun jeu</p>';
            } else{
                foreach ($jouer as $ligne){
                    /** @var ClassementJeu $classJeu */
                    $classJeu = (new SeClasserRepository())->recupererDepuisJouer($ligne);
                    echo '<p class="ligne-jeu">
                                    <small>'.$ligne[1]->getNomMode().'</small>
                                    <img src="../'.$ligne[0]->getPathLogo().'" alt="'.$ligne[0]->getNomJeu().'">
                                    <img class="classement" src="../'.$classJeu->getClassPath().'" alt="Classement">';
                    if($estBonUtilisateur){
                        echo '<a href="../web/controleurFrontal.php?controleur=jouer&action=afficherModifJouer&id=' . $idURL . '&jeu='.$ligne[0]->getCodeJeu().'&mode='.$ligne[1]->getNomMode().'"> (Modif) </a>
                                <a href="../web/controleurFrontal.php?controleur=jouer&action=supprimerJouer&id=' . $idURL . '&jeu='.$ligne[0]->getCodeJeu().'&mode='.$ligne[1]->getNomMode().'">X</a>';
                    }
                    echo "</p>";
                }
            }
            ?>
            <?php if($estBonUtilisateur):?>
            <a href="../web/controleurFrontal.php?controleur=jouer&action=afficherFormulaireJouer&id=<?=$idURL?>">Nouveau jeu?</a>
            <?php endif; ?>
        </div>
        <?php
        if($estBonUtilisateur){
            echo '<div class="lienMAJ">';
            echo '    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&id='.$idURL.'">Modifier des informations ?</a>';
            echo '    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=supprimer&id=' . $idURL . '">Supprimer le compte</a>';
            echo '</div>';
        }
        ?>
    </div>
    <?php endif; ?>
    <div class="devCoach">
        <?php if($estCoach):?>
        <a href = "../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id=<?=$idURL?>">Voir la page coach</a>
        <?php endif;?>
        <?php if(!($estCoach || !$estBonUtilisateur)):?>
        <a href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireCreation&id=<?=$idURL?>"> je souhaite devenir coach...</a>
        <?php endif;?>
    </div>
</div>
