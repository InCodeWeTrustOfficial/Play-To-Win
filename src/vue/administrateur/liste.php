<?php

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Utilisateur;

/** @var AbstractDataObject[] $objets */
/** @var string $controleur  */
/** @var string $objetType  */

foreach ($objets as $objet) {
    $idHTML = htmlspecialchars($objet->getId());
    $idURL = rawurlencode($objet->getId());

echo "$objetType de login : ";

echo '<p>

<a href = "../web/controleurFrontal.php?controleur=' . $objetType . '&action=afficherDetail&id=' . $idURL . '">' . $idHTML . '</a>';
    if (ConnexionUtilisateur::estAdministrateur()) {
        echo ' <a href = "../web/controleurFrontal.php?controleur=' . $objetType . '&action=afficherFormulaireMiseAJour&id=' . $idURL . '"> (ModifICI) </a>
        <a href = "../web/controleurFrontal.php?controleur=' . $objetType . '&action=supprimer&id=' . $idURL . '"> (-)</a>';
    }
    echo '</p>';
}

echo '<br><h3>Lien pour créer : <a href = "../web/controleurFrontal.php?controleur=' . $objetType . '&action=afficherFormulaireCreation"> Ici</a></h3>';

