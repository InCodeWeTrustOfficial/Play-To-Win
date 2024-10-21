<?php

use App\Covoiturage\Lib\ConnexionUtilisateur;

echo "<h2>Liste des utilisateurs</h2>";
/** @var Utilisateur[] $utilisateurs */
/** @var string $controleur  */
foreach ($utilisateurs as $utilisateur) {
    $loginHTML = htmlspecialchars($utilisateur->getId());
    $loginURL = rawurlencode($utilisateur->getId());
    echo '<p>
Utilisateur de login : 
<a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=afficherDetail&login=' . $loginURL . '">' . $loginHTML . '</a>';
    if (ConnexionUtilisateur::estAdministrateur()) {
        echo ' <a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=afficherFormulaireMiseAJour&login=' . $loginURL . '"> (ModifICI) </a>
        <a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=supprimer&login=' . $loginURL . '"> (-)</a>';
    }
    echo '</p>';
}
echo '<br><h3>Lien pour créer un utilisateur : <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=afficherFormulaireCreation">Ici</a></h3>';

