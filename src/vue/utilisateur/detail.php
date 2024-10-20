<?php
/** @var Utilisateur $utilisateur */

use App\Covoiturage\Lib\ConnexionUtilisateur;

$loginHTML = htmlspecialchars($utilisateur->getLogin());
$loginURL = rawurlencode($utilisateur->getLogin());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
echo '<p>Login : '. $loginHTML .' </p>';
echo '<p>Nom : '. $nomHTML .' </p>';
echo '<p>Prenom : '. $prenomHTML .' </p>';

if(ConnexionUtilisateur::estUtilisateur($utilisateur->getLogin())){
    echo '
    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireMiseAJour&login='.$loginURL.'"> (ModifICI) </a>
    <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=supprimer&login='.$loginURL.'"> (-)</a>
    ';
}

