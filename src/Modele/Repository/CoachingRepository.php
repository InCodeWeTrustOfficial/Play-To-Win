<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Coaching;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

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
