<?php
/** @var Services $service */
/** @var Utilisateur $utilisateur */

use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

$codeServiceHTML = htmlspecialchars($service->getCodeService());
$nomServiceHTML = htmlspecialchars($service->getNomService());
$descriptionServiceHTML = htmlspecialchars($service->getDescriptionService());
$coachHTML = htmlspecialchars($service->getCoach());
$prixHTML = htmlspecialchars($service->getPrixService());

echo '<p>codeService : '. $codeServiceHTML .' </p>';
echo '<p>nomService : '. $nomServiceHTML .' </p>';
echo '<p>descriptionService : '. $descriptionServiceHTML .' </p>';
echo '<p>coach : '. $coachHTML .' </p>';
echo '<p>Prix : '. $prixHTML .' </p>';

echo '
    <a href = "../web/controleurFrontal.php?controleur=service&action=afficherFormulaireMiseAJour&codeService='.$service->getCodeService().'"> (ModifICI) </a>
    <a href = "../web/controleurFrontal.php?controleur=service&action=supprimer&codeService='.$service->getCodeService().'"> (-)</a>
';
