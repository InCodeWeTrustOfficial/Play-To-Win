<?php
/** @var Utilisateur $utilisateur */

$loginHTML = htmlspecialchars($utilisateur->getLogin());
$nomHTML = htmlspecialchars($utilisateur->getNom());
$prenomHTML = htmlspecialchars($utilisateur->getPrenom());
echo '<p>Login : '. $loginHTML .' </p>';
echo '<p>Nom : '. $nomHTML .' </p>';
echo '<p>Prenom : '. $prenomHTML .' </p>';

