<?php
/** @var Utilisateur $utilisateur */

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\DataObject\Utilisateur;

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

echo '<p>id : '. $idHTML .' </p>';
echo '<p>Nom : '. $nomHTML .' </p>';
echo '<p>Prenom : '. $prenomHTML .' </p>';
echo '<p>Pseudo : '. $pseudoHTML .' </p>';
echo '<p>Email : '. $emailHTML .' </p>';
echo '<p>Date de naissance : '. $dateNaissanceHTML .' </p>';
echo '<p>Avatar : '. $avatarHTML .' </p>';

if(ConnexionUtilisateur::estUtilisateur($utilisateur->getId()) || ConnexionUtilisateur::estAdministrateur()){
    echo '
    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&id='.$idURL.'"> (ModifICI) </a>
    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=supprimer&id='.$idURL.'"> (-)</a>
    ';
}

