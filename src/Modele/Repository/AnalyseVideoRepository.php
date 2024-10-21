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
        return ["codeService", "nomService", "descriptionService", "prixService", "idUtilisateur", "nomJeu", "nbJourRendu"];
    }

    protected function formatTableauSQL(AbstractDataObject $services): array {
        /** @var AnalyseVideo $services */
        return array(
            ":codeServiceTag" => $services->getCodeService(),
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
            $servicesFormatTableau["codeService"],
            $servicesFormatTableau["nomService"],
            $servicesFormatTableau["descriptionService"],
            (float) $servicesFormatTableau["prixService"],
            $servicesFormatTableau["idUtilisateur"],
            $servicesFormatTableau["nomJeu"],
            (int) $servicesFormatTableau["nbJourRendu"]
        );
    }




}
