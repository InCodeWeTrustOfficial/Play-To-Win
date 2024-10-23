<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class AnalyseVideoRepository extends ServiceRepository {

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Services {
        return new AnalyseVideo(
            $servicesFormatTableau["codeService"],
            $servicesFormatTableau["nomService"],
            $servicesFormatTableau["descriptionService"],
            $servicesFormatTableau["prixService"],
            $servicesFormatTableau["idCoach"],
            $servicesFormatTableau["nomJeu"],
            $servicesFormatTableau["nbJourRendu"]
        );
    }

    public function getNomsColonnesServiceAll(): array {
        return array_merge(parent::getNomsColonnes(), $this->getNomsColonnes());
    }

    public function getNomsColonnesService(): array {
        return ["codeService","nbJourRendu"];
    }

    function getNomTableService(): string {
        return "p_AnalysesVideo";
    }

    function formatTableauSQLServices(AbstractDataObject $services) {
        /** @var AnalyseVideo $services */
        return array(
            ":codeServiceTag" => $services->getCodeService(),
            ":nbJourRenduTag" => $services->getNbJourRendu()
        );
    }
}
