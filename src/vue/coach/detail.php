<?php
/** @var Coach $coach */


use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\Coach;

$idURL = rawurlencode($coach->getId());

$idHTML = htmlspecialchars($coach->getId());
$nomHTML = htmlspecialchars($coach->getNom());
$prenomHTML = htmlspecialchars($coach->getPrenom());
$pseudoHTML = htmlspecialchars($coach->getPseudo());
$emailHTML = htmlspecialchars($coach->getEmail());
$biographieHTML = htmlspecialchars($coach->getBiographie());

$dateNaissanceHTML = htmlspecialchars($coach->getDateNaissance()->format("d/m/Y"));

$avatarHTML = htmlspecialchars($coach->getAvatarPath());

echo '<p>id du coach : '. $idHTML .' </p>';
echo '<p>Nom du coach: '. $nomHTML .' </p>';
echo '<p>Prenom du coach: '. $prenomHTML .' </p>';
echo '<p>Pseudo du coach: '. $pseudoHTML .' </p>';
echo '<p>Email pour contacter le coach: '. $emailHTML .' </p>';
echo '<p>Date de naissance du coach: '. $dateNaissanceHTML .' </p>';
echo '<p>Avatar du coach: '. $avatarHTML .' </p>';
echo '<p>Biographie du coach: '.$biographieHTML.'</p>';
echo '<a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherDetail&id='.$idURL.'">Voir page Joueur</a>';

if (ConnexionUtilisateur::estUtilisateur($coach->getId()) || ConnexionUtilisateur::estAdministrateur()) {
    echo '<p><a href = "../web/controleurFrontal.php?controleur=coach&action=afficherFormulaireMiseAJour&id=' . $idURL . '">Modifier formulaire coach ici</a></p>';
    echo '<p><a href = "../web/controleurFrontal.php?controleur=coach&action=supprimer&id=' . $idURL . '">Se désinscrire de la liste des coachs !</a></p>';
}

