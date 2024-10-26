<?php
/** @var Utilisateur $utilisateur */

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;

$idURL = rawurlencode($utilisateur->getId());

$idHTML = htmlspecialchars($utilisateur->getId());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
$pseudoHTML = htmlspecialchars($utilisateur->getPseudo());

if($utilisateur->getEmail() != ""){
    $emailHTML = htmlspecialchars($utilisateur->getEmail());
} else {
    $emailHTML = "Vous devez valider l'email suivante : ".htmlspecialchars($utilisateur->getEmailAValider());
}
$dateNaissanceHTML = htmlspecialchars($utilisateur->getDateNaissance()->format("d/m/Y"));
if($utilisateur->isAdmin()){
    echo "Administrateur !";
}
$avatarHTML = htmlspecialchars($utilisateur->getAvatarPath());

echo '<p>Langues parlées: ';
$langues = (new ParlerRepository())->recupererLangues($utilisateur->getId());
if($langues == null){
    echo 'Aucune :(';
} else{
    /** @var Langue $l */
    foreach ($langues as $l){
        echo '<p>
<img src="../'.$l->getDrapeauPath().'" alt="Drapeau" style="width: 40px; height: 26px; object-fit: cover;"> </p>';
    }
}
echo '</p>';

echo '<p>id : '. $idHTML .' </p>';
echo '<p>Nom : '. $nomHTML .' </p>';
echo '<p>Prenom : '. $prenomHTML .' </p>';
echo '<p>Pseudo : '. $pseudoHTML .' </p>';
echo '<p>Email : '. $emailHTML .' </p>';
echo '<p>Date de naissance : '. $dateNaissanceHTML .' </p>';
echo '<p>
<img src="../'.$utilisateur->getAvatarPath().'" alt="Photo de profil" style="width: 70px; height: 70px; object-fit: cover;" 
     onerror="this.onerror=null; this.src=\'../ressources/img/defaut_pp.png\';">
</p>';
if( (new CoachRepository())->estCoach($utilisateur->getId())){
    echo 'Utilisateur coach !';
    echo '<a href = "../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id='.$idURL.'"> Voir sa page de coach </a>';
} else{
    if(ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()) {
        echo 'Devenir coach ?
          <a href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireCreation&id=' . $idURL . '"> je souhaite devenir coach... </a>
          ';
    }
}

if (ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()) {

    echo '<p>
          <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireAvatar&id=' . $idURL . '">Envie de changer de pp?</a>
</p>';

    echo '<p>
    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&id=' . $idURL . '"> (ModifICI) </a>';
    echo '<a href = "../web/controleurFrontal.php?controleur=utilisateur&action=supprimer&id=' . $idURL . '"> (-)</a>
    </p>';

}

