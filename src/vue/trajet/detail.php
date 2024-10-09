<?php
/** @var Trajet $trajet */

use App\Covoiturage\Modele\DataObject\Trajet;

$idHTML = htmlspecialchars($trajet->getId());
$departHTML = htmlspecialchars($trajet->getDepart());
$arriveHTML = htmlspecialchars($trajet->getArrivee());
$dateHTML = htmlspecialchars($trajet->getDate()->format("d/m/Y"));
$prixHTML = htmlspecialchars($trajet->getPrix());
$conducteurHTML = htmlspecialchars($trajet->getConducteur()->getNom() . " ". $trajet->getConducteur()->getPrenom());
$nonFumeurHTML = htmlspecialchars($trajet->isNonFumeur()?"oui":"non");
echo '<p>Id : '. $idHTML .' </p>';
echo '<p>Depart : '. $departHTML .' </p>';
echo '<p>Arrivée : '. $arriveHTML .' </p>';
echo '<p>Date : '. $dateHTML .' </p>';
echo '<p>Prix : '. $prixHTML .' </p>';
echo '<p>Conducteur : '. $conducteurHTML .' </p>';
echo '<p>Non Fumeur : '. $nonFumeurHTML .' </p>';