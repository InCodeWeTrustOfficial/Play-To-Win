<?php
/** @var Services $service */

$codeServiceHTML = htmlspecialchars($service->getCodeService());
$nomServiceHTML = htmlspecialchars($service->getNomService());
$descriptionServiceHTML = htmlspecialchars($service->getDescriptionService());
$coachHTML = htmlspecialchars($service->getCoach());
$coachURL = rawurlencode($service->getCoach());
$prixHTML = htmlspecialchars($service->getPrixService());
$duree = htmlspecialchars($service->getDuree());

echo '<h1 class="service-name">' . $nomServiceHTML . '</h1>';

echo '
    <div class="game-info">
        <img src="../ressources/img/jeux/lol.png" alt="Icon" class="game-icon">
        <span class="game-name">' . $service->getNomJeu() . '</span>
        <span class="service-price">' . $prixHTML . ' €</span>
        <span class="service-price"> ' . $duree . ' min </span>
    </div>
';

echo '
    <div class="coach-info">
        <a href="../web/controleurFrontal.php?controleur=utilisateur&action=afficherDetail&id=' . $coachURL . '" class="detail-link">
            <h3 class="coach-name">' . $coachHTML . '</h3>
        </a>
        <hr class="separator">
    </div>
';

echo '<p class="service-description">' . $descriptionServiceHTML . '</p>';

echo '
    <div class="button-container">
        <a href="../web/controleurFrontal.php?controleur=' . $service->getTypeService() . '&action=afficherFormulaireMiseAJour&codeService=' . $service->getCodeService() . '" class="btn modify-btn">Modifier</a>
        <a href="../web/controleurFrontal.php?controleur=' . $service->getTypeService() . '&action=supprimer&codeService=' . $service->getCodeService() . '" class="btn delete-btn">Supprimer</a>
    </div>
';
?>