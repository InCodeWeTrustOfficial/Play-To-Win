<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class AnalyseVideoRepository extends ServiceRepository {

    protected function getNomTable(): string
    {
        return "p_Services";
    }
    protected function getNomClePrimaire(): string {
        return "codeService";
    }
    protected function getNomsColonnes(): array {
        return ["codeService", "nomService", "descriptionService", "prixService", "idUtilisateur","nomJeu", "dateRendu"];
    }

    protected function formatTableauSQL(AbstractDataObject $services): array {
        /** @var AnalyseVideo $services */
        return array(
            ":codeServiceTag" => $services->getCodeService(),
            ":nomServiceTag" => $services->getNomService(),
            ":descriptionServiceTag" => $services->getDescriptionService(),
            ":prixServiceTag" => $services->getPrixService(),
            ":idUtilisateurTag" => $services->getCoach(),
            ":nomJeuTag" => $services->getNomJeu(),
            ":dateRenduTag" => $services->getRendu(),
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Services {
        return new AnalyseVideo(
            $servicesFormatTableau[0],
            $servicesFormatTableau[1],
            $servicesFormatTableau[2],
            $servicesFormatTableau[3],
            $servicesFormatTableau[4],
            $servicesFormatTableau[5],
            $servicesFormatTableau[6]
        );
    }

}