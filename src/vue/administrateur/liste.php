<?php

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Utilisateur;

/** @var AbstractDataObject[] $objets */
/** @var string $controleur  */

foreach ($objets as $objet) {
    $idHTML = htmlspecialchars($objet->getId());
    $idURL = rawurlencode($objet->getId());

echo "$controleur de login : ";
echo '<p>
<a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=afficherDetail&id=' . $idURL . '">' . $idHTML . '</a>';
    if (ConnexionUtilisateur::estAdministrateur()) {
        echo ' <a href = "../web/controleurFrontal.php?controleur=' . $objet->getControleur()  . '&action=afficherFormulaireMiseAJour&id=' . $idURL . '"> (ModifICI) </a>
        <a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=supprimer&id=' . $idURL . '"> (-)</a>';
    }
    echo '</p>';
}

if($controleur == "coach"){
    echo '<br><h3>Lien pour créer : <a href = "../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireCreation">Ici</a> </h3>';
} else {
    echo '<br><h3>Lien pour créer : <a href = "../web/controleurFrontal.php?controleur=' . $controleur . '&action=afficherFormulaireCreation">Ici</a> </h3>';
}