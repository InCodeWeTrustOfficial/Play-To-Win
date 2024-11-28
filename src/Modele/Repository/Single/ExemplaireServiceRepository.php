<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;

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

    public function recupererParCommande(string $idCommande): array {
        $sql = "SELECT " . join(',', $this->getNomsColonnes()) .
            " FROM " . $this->getNomTable() .
            " WHERE idCommande = :idCommandeTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array("idCommandeTag" => $idCommande);
        $pdoStatement->execute($values);

        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }

        return $objets;
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
        $service = (new AnalyseVideoRepository())->recupererParClePrimaire($servicesFormatTableau["codeService"]);
        if ($service === null) {
            $service = (new CoachingRepository())->recupererParClePrimaire($servicesFormatTableau["codeService"]);
        }

        return new ExemplaireService (
            $servicesFormatTableau["idExemplaire"],
            $servicesFormatTableau["etatService"],
            $servicesFormatTableau["sujet"],
            $service,
            (new CommandeRepository())->recupererParClePrimaire($servicesFormatTableau["idCommande"])
        );
    }
}