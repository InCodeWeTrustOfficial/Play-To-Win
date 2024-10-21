<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

abstract class ServiceRepository extends AbstractRepository{

    protected function getNomTable(): string {
        return "p_Services";
    }
    protected function getNomClePrimaire(): string {
        return "codeService	";
    }
    protected function getNomsColonnes(): array {
        return ["codeService", "nomService", "descriptionService", "prixService", "idUtilisateur","nomJeu"];
    }

    protected function formatTableauSQL(AbstractDataObject $services): array {
        /** @var Services $services */
        return array(
            ":codeServiceTag" => $services->getCodeService(),
            ":nomServiceTag" => $services->getNomService(),
            ":descriptionServiceTag" => $services->getDescriptionService(),
            ":prixServiceTag" => $services->getPrixService(),
            ":idUtilisateurTag" => $services->getCoach(),
            ":nomJeuTag" => $services->getNomJeu(),
        );
    }

}