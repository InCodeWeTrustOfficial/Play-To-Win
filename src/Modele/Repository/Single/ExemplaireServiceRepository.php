<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\DataObject\Utilisateur;

class ExemplaireServiceRepository extends AbstractRepository{

    protected function getNomTable(): string {
        return "p_ExemplaireService";
    }
    protected function getNomClePrimaire(): string {
        return "idExemplaire";
    }
    protected function getNomsColonnes(): array {
        return ["idExemplaire", "etatService", "sujet", "codeService", "idCommande"];
    }

    protected function formatTableauSQL(AbstractDataObject $Exservices): array {
        /** @var ExemplaireService $Exservices */
        return array(
            ":idExemplaireTag" => $Exservices->getIdExemplaire(),
            ":etatServiceTag" => $Exservices->getEtatService(),
            ":sujetTag" => $Exservices->getSujet(),
            ":codeServiceTag" => $Exservices->getCodeService(),
            ":idCommandeTag" => $Exservices->getIdCommande(),
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): ExemplaireService {
        return new ExemplaireService (
            $servicesFormatTableau["idExemplaire"],
            $servicesFormatTableau["etatService"],
            $servicesFormatTableau["sujet"],
            $servicesFormatTableau["codeService"],
            $servicesFormatTableau["idCommande"]
        );
    }
}