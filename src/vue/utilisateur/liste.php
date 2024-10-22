<?php

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\DataObject\Utilisateur;

echo "<h2>Liste des utilisateurs</h2>";
/** @var Utilisateur[] $utilisateurs */
/** @var string $controleur  */
foreach ($utilisateurs as $utilisateur) {
    $idHTML = htmlspecialchars($utilisateur->getId());
    $idURL = rawurlencode($utilisateur->getId());
    echo '<p>
Utilisateur de login : 
<a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=afficherDetail&id=' . $idURL . '">' . $idHTML . '</a>';
    if (ConnexionUtilisateur::estAdministrateur()) {
        echo ' <a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=afficherFormulaireMiseAJour&id=' . $idURL . '"> (ModifICI) </a>
        <a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=supprimer&id=' . $idURL . '"> (-)</a>';
    }
    echo '</p>';
}
echo '<br><h3>Lien pour créer un utilisateur : <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=afficherFormulaireCreation">Ici</a></h3>';

