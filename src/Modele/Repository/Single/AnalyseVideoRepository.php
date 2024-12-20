<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Service;

class AnalyseVideoRepository extends ServiceRepository {

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Service {
        return new AnalyseVideo(
            $servicesFormatTableau["codeService"],
            $servicesFormatTableau["nomService"],
            $servicesFormatTableau["descriptionService"],
            $servicesFormatTableau["prixService"],
            (new CoachRepository())->recupererParClePrimaire($servicesFormatTableau["idCoach"]),
            (new JeuRepository())->recupererParClePrimaire($servicesFormatTableau["codeJeu"]),
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
            ":codeServiceTag" => $services->getId(),
            ":nbJourRenduTag" => $services->getNbJourRendu()
        );
    }
}
