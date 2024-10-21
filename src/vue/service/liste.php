<?php

use App\Covoiturage\Modele\DataObject\Services;

echo "<h2>Liste des services proposé</h2>";
/** @var Trajet[] $trajets */
/** @var string $controleur  */
foreach ($trajets as $trajet){
    $idHTML = htmlspecialchars($trajet->getId());
    $idURL = rawurlencode($trajet->getId());
    echo '<p>
          '.$trajet.'
         <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=afficherDetail&id='.$idURL.'">(Détail)</a>
         <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=afficherFormulaireMiseAJour&id='.$idURL.'"> (ModifICI) </a>
         <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=supprimer&id='.$idURL.'"> (-)</a>
         </p>';

}
echo '<br><h3>Lien pour créer un trajet : <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=afficherFormulaireCreation">Ici</a></h3>';