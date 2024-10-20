<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class AnalyseVideoRepository extends ServiceRepository {

    protected function getNomTable(): string {
        return "p_AnalysesVideo";
    }

    protected function getNomClePrimaire(): string {
        return "codeService";
    }

    protected function getNomsColonnes(): array {
        return ["nomService", "descriptionService", "prixService", "idUtilisateur", "nomJeu", "nbJourRendu"];
    }

    protected function formatTableauSQL(AbstractDataObject $services): array {
        /** @var AnalyseVideo $services */
        return array(
            ":nomServiceTag" => $services->getNomService(),
            ":descriptionServiceTag" => $services->getDescriptionService(),
            ":prixServiceTag" => $services->getPrixService(),
            ":idCoachTag" => $services->getCoach(),
            ":nomJeuTag" => $services->getNomJeu(),
            ":nbJourRenduTag" => $services->getNbJourRendu()
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Services {
        return new AnalyseVideo(
            null,
            $servicesFormatTableau[0], // nomService
            $servicesFormatTableau[1], // descriptionService
            $servicesFormatTableau[2], // prixService
            $servicesFormatTableau[3], // idUtilisateur
            $servicesFormatTableau[4], // nomJeu
            $servicesFormatTableau[5], // nbJourRendu
        );
    }

}
