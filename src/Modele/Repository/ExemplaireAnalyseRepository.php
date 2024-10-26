<?php

namespace App\PlayToWin\Modele\Repository;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\ExemplaireAnalyse;

class ExemplaireAnalyseRepository extends ExemplaireServiceRepository {

    function getNomTable(): string {
        return "p_ExemplaireService";
    }
    function getNomClePrimaire(): string {
        return "idExemplaire";
    }
    function getNomsColonnes(): array {
        return ["idExemplaire", "etatService", "sujet", "codeService", "idCommande", "quantite", "nbJourRendu"];
    }

    protected function formatTableauSQL(AbstractDataObject $Exservices): array {
        /** @var ExemplaireAnalyse $Exservices */
        return array(
            ":idExemplaireTag" => $Exservices->getIdExemplaire(),
            ":etatServiceTag" => $Exservices->getEtatService(),
            ":sujetTag" => $Exservices->getSujet(),
            ":codeServiceTag" => $Exservices->getCodeService(),
            ":idCommandeTag" => $Exservices->getIdCommande(),
            ":quantiteTag" => $Exservices->getQuantite(),
            ":nbJourRenduTag" => $Exservices->getNbJourRendu(),
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): ExemplaireAnalyse {
        return new ExemplaireAnalyse (
            $servicesFormatTableau["idExemplaire"],
            $servicesFormatTableau["etatService"],
            $servicesFormatTableau["sujet"],
            $servicesFormatTableau["codeService"],
            $servicesFormatTableau["idCommande"],
            $servicesFormatTableau["quantite"],
            $servicesFormatTableau["nbJourRendu"]
        );
    }
}