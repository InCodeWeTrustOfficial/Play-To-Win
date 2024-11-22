<?php
/** @var Service $service */

use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Lib\ConnexionUtilisateur;

$codeServiceHTML = htmlspecialchars($service->getId());
$nomServiceHTML = htmlspecialchars($service->getNomService());
$descriptionServiceHTML = htmlspecialchars($service->getDescriptionService());
$coachHTML = htmlspecialchars($service->getCoach());
$coachURL = rawurlencode($service->getCoach());
$prixHTML = htmlspecialchars($service->getPrixService());
$nbJourAvantRendu = htmlspecialchars($service->getNbJourRendu());

echo '<h1 class="service-name">' . $nomServiceHTML . '</h1>';

echo '
    <div class="game-info">
        <img src="../ressources/img/jeux/' . htmlspecialchars($service->getCodeJeu()) . '.png" alt="Icon" class="game-icon">
        <span class="game-name">' . htmlspecialchars($service->getNomJeu()) . '</span>
        <span class="service-price">' . $prixHTML . ' €</span>
        <span class="service-price"> ' . $nbJourAvantRendu . ' Jour</span>
    </div>
';

echo '
    <div class="coach-info">
        <a href="../web/controleurFrontal.php?controleur=coach&action=afficherDetail&id=' . $coachURL . '" class="detail-link">
            <h3 class="coach-name">' . $coachHTML . '</h3>
        </a>
        <hr class="separator">
    </div>
';

echo '<p class="service-description">' . $descriptionServiceHTML . '</p>';

$boutons = '<div class="button-container">';
$boutons .= '<a href="../web/controleurFrontal.php?controleur=' . $service->getControleur() . '&action=ajouterAuPanier&id=' . $service->getId() . '" class="btn modify-btn">Ajouter</a>';

if (ConnexionUtilisateur::estConnecte() &&
    (ConnexionUtilisateur::estAdministrateur() ||
        ConnexionUtilisateur::getIdUtilisateurConnecte() === $service->getCoach())) {

    $boutons .= '
        <a href="../web/controleurFrontal.php?controleur=' . $service->getControleur() . '&action=afficherFormulaireMiseAJour&id=' . $service->getId() . ' &idCoach=' . $coachURL .'" class="btn modify-btn">Modifier</a>
        <a href="../web/controleurFrontal.php?controleur=' . $service->getControleur() . '&action=supprimer&id=' . $service->getId() . '&idCoach=' . $coachURL .'" class="btn delete-btn">Supprimer</a>
    ';
}

$boutons .= '</div>';
echo $boutons;