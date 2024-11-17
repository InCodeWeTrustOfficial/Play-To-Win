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

$aValideEmail = $utilisateur->getEmail() !== "";
$estAdmin = ConnexionUtilisateur::estAdministrateur();
$estBonUtilisateur = $estAdmin || (ConnexionUtilisateur::estConnecte() && ConnexionUtilisateur::estUtilisateur($utilisateur->getId()));
$estCoach = (new CoachRepository())->estCoach($utilisateur->getId());
?>

<div class="utilisateurDetail-conteneur">

    <div class="user-email <?php if ($aValideEmail) echo 'cache'?>">
        <h2><?php echo "Vous devez valider l'email suivante : ".htmlspecialchars($utilisateur->getEmailAValider());?></h2>
    </div>

    <div class="user-main-conteneur <?php if (!$aValideEmail) echo 'cache'?> <?php if ($estAdmin) echo 'admin'?>">
        <div class ="avatar-conteneur">
            <img class="ppUser" src="../<?=$utilisateur->getAvatarPath()?>" alt="Photo de profil"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_pp.png';">
            <div class="modifAvatar <?php if (!$estBonUtilisateur) echo 'cache';?>">
                <a href="../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireAvatar&id=<?=$idURL?>"></a>
            </div>
        </div>

        <div class="infos-generales">
            <p>id : <?=$idHTML?></p>
            <p>Nom : <?=$nomHTML?></p>
            <p>Prenom : <?=$prenomHTML?></p>
            <p>Pseudo : <?=$pseudoHTML?></p>
            <p>Email : <?=$emailHTML?></p>
            <p>Date de naissance : <?=$dateNaissanceHTML?></p>
        </div>
    </div>

    <div class="devCoach">
        <a <?php if (!$estCoach) echo 'class="cache"'?> href = "../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id=<?=$idURL?>">Voir la page coach</a>
        <a <?php if (!(!$estCoach || !$estBonUtilisateur)) echo 'class="cache";'?> href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireCreation&id=' . $idURL . '"> je souhaite devenir coach...</a>
    </div>

</div>

<?php
echo '<p>Langues parlées: ';
$langues = (new ParlerRepository())->recupererLangues($utilisateur->getId());
if($langues == null){
    echo 'Aucune :(';
} else{
    /** @var Langue $l */
    foreach ($langues as $l){
        echo '<p> <img src="../'.$l->getDrapeauPath().'" alt="Drapeau" style="width: 40px; height: 26px; object-fit: cover;">';
        if(ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()){
            echo '<a href="../web/controleurFrontal.php?controleur=langue&action=supprimerLangue&id=' . $idURL . '&lang='.$l->getCodeAlpha().'">(-)</a></p>';
        }
  echo '</p>';
    }
}
if(ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()){
    echo '<p> Ajouter une nouvelle langue ?';
    echo '<a href="../web/controleurFrontal.php?controleur=langue&action=afficherFormulaireAjout&id=' . $idURL . '">Cliquez ici</a></p>';
}
echo '</p>';

echo '<p> Jeux joués avec leur mode:';
$jouer = (new JouerRepository())->recupererModeJeuClassement($utilisateur->getId());
if($jouer == null){
    echo 'Aucun jeu :(';
} else{
    foreach ($jouer as $ligne){
        /** @var ClassementJeu $classJeu */
        $classJeu = (new SeClasserRepository())->recupererDepuisJouer($ligne);
        echo "<p>";
        echo $ligne[0]->getNomJeu();
        echo $ligne[1]->getNomMode();
        echo $classJeu->getClassement()->getNomClassement();
        echo '<img src="../'.$classJeu->getClassPath().'" alt="Classement" style="width: 30px; height: 30px; object-fit: cover;">';
        if(ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()){
            echo ' <a href="../web/controleurFrontal.php?controleur=jouer&action=afficherModifJouer&id=' . $idURL . '&jeu='.$ligne[0]->getCodeJeu().'&mode='.$ligne[1]->getNomMode().'"> (Modif) </a>
            <a href="../web/controleurFrontal.php?controleur=jouer&action=supprimerJouer&id=' . $idURL . '&jeu='.$ligne[0]->getCodeJeu().'&mode='.$ligne[1]->getNomMode().'">(-)</a></p>';
        }
        echo "</p>";
    }
}
if(ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()){
    echo '<p> Ajouter un nouveau jeu ?';
    echo '<a href="../web/controleurFrontal.php?controleur=jouer&action=afficherFormulaireJouer&id=' . $idURL . '">Cliquez ici</a></p>';
}
echo '<p>
<img src="../'.$utilisateur->getAvatarPath().'" alt="Photo de profil" style="width: 70px; height: 70px; object-fit: cover;" 
     onerror="this.onerror=null; this.src=\'../ressources/img/defaut_pp.png\';">
</p>';


if (ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()) {
    echo '<p>
    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&id=' . $idURL . '"> (ModifICI) </a>';
    echo '<a href = "../web/controleurFrontal.php?controleur=utilisateur&action=supprimer&id=' . $idURL . '"> (-)</a>
    </p>';

}

