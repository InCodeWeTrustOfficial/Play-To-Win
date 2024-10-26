<?php

namespace App\PlayToWin\Modele\Repository;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\DataObject\Utilisateur;

abstract class ExemplaireServiceRepository extends AbstractRepository{

    protected function getNomTable(): string {
        return "p_ExemplaireService";
    }
    protected function getNomClePrimaire(): string {
        return "idExemplaire";
    }
    protected function getNomsColonnes(): array {
        return ["idExemplaire", "etatService", "sujet", "codeService", "idCommande", "quantite"];
    }

    protected function formatTableauSQL(AbstractDataObject $Exservices): array {
        /** @var ExemplaireService $Exservices */
        return array(
            ":idExemplaireTag" => $Exservices->getIdExemplaire(),
            ":etatServiceTag" => $Exservices->getEtatService(),
            ":sujetTag" => $Exservices->getSujet(),
            ":codeServiceTag" => $Exservices->getCodeService(),
            ":idCommandeTag" => $Exservices->getIdCommande(),
            ":quantiteTag" => $Exservices->getQuantite(),
        );
    }


}