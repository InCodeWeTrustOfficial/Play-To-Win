<?php

use App\Covoiturage\Modele\DataObject\Services;

echo "<h2>Liste des services proposé</h2>";
/** @var Services[] $services */
/** @var string $controleur  */
foreach ($services as $service){
    echo '<p>
          '.$service->getNomService().'
          <a href = "../web/controleurFrontal.php?controleur='.$controleur.'&action=afficherDetail&codeService='.$service->getCodeService().'">(Détail)</a>
         </p>';

}
echo '<br><h3>Lien pour créer un services : <a href="controleurFrontal.php?controleur=service&action=afficherFormulaireProposerService">Création </a></h3>';