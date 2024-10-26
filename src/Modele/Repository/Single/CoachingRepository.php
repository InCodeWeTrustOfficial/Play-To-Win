<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Coaching;
use App\PlayToWin\Modele\DataObject\Services;
class CoachingRepository extends ServiceRepository {

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Services {
        return new Coaching (
            $servicesFormatTableau["codeService"],
            $servicesFormatTableau["nomService"],
            $servicesFormatTableau["descriptionService"],
            $servicesFormatTableau["prixService"],
            $servicesFormatTableau["idCoach"],
            $servicesFormatTableau["nomJeu"],
            $servicesFormatTableau["duree"]
        );
    }

    public function getNomsColonnesServiceAll(): array {
        return array_merge(parent::getNomsColonnes(), $this->getNomsColonnes());
    }

    public function getNomsColonnesService(): array {
        return ["codeService","duree"];
    }

    function getNomTableService(): string {
        return "p_Coachings";
    }

    function formatTableauSQLServices(AbstractDataObject $services) {
        /** @var Coaching $services */
        return array(
            ":codeServiceTag" => $services->getCodeService(),
            ":dureeTag" => $services->getDuree()
        );
    }
}
