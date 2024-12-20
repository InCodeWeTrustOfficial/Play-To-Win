<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use PDOException;

abstract class ServiceRepository extends AbstractRepository{

    abstract function getNomTableService(): string;
    abstract function getNomsColonnesService(): array;

    protected function getNomTable(): string {
        return "p_Services";
    }
    public function getNomClePrimaire(): string {
        return "codeService	";
    }

    protected function getNomsColonnes(): array {
        return ["codeService", "nomService", "descriptionService", "prixService", "idCoach","codeJeu"];
    }

    public function supprimer(string $cle) : bool{
        $valide = true;
        try{
            // Suppression d'abord dans la table p_AnalysesVideo
            $sql = "DELETE FROM " . $this->getNomTableService() . " WHERE " . $this->getNomClePrimaire() . " = :cleTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = array("cleTag" => $cle);
            $pdoStatement->execute($values);

            // Puis suppression dans la table p_Services
            $sql = "DELETE FROM " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . " = :cleTag";
            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $pdoStatement->execute($values);

        }catch(PDOException){
            $valide = false;
        }
        return $valide;
    }

    public function ajouter(AbstractDataObject $objet): bool {
        $valide = true;
            $sqlService = "INSERT INTO " . $this->getNomTable() . " (" . join(',', $this->getNomsColonnes()) . ") 
            VALUES (" . join(',', array_keys($this->formatTableauSQL($objet))) . ")";

            $pdoStatementService = ConnexionBaseDeDonnees::getPdo()->prepare($sqlService);
            $valuesService = $this->formatTableauSQL($objet);
            $pdoStatementService->execute($valuesService);

            $codeService = ConnexionBaseDeDonnees::getPdo()->lastInsertId();
            $valuesAnalyse = $this->formatTableauSQLServices($objet);
            $valuesAnalyse[":codeServiceTag"] = $codeService;

            $sqlAnalyse = "INSERT INTO " . $this->getNomTableService() . " (" . join(',', $this->getNomsColonnesService()) . ") 
                       VALUES (" . join(',', array_keys($valuesAnalyse)) . ")";

            $pdoStatementAnalyse = ConnexionBaseDeDonnees::getPdo()->prepare($sqlAnalyse);
            $pdoStatementAnalyse->execute($valuesAnalyse);

        return $valide;
    }

    public function recupererParClePrimaire(string $cle): ?AbstractDataObject {
        $sql = "SELECT s." . join(', s.', $this->getNomsColonnes()) . ", p." . join(', p.', $this->getNomsColonnesService()) . " 
            FROM " . $this->getNomTable() . " s 
            JOIN " . $this->getNomTableService() . " p 
            ON p." . $this->getNomClePrimaire() . " = s." . $this->getNomClePrimaire() . " 
            WHERE s." . $this->getNomClePrimaire() . " = :cleTag;";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $values = array("cleTag" => $cle);
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();

        if ($objetFormatTableau == null) {
            return null;
        }
        return $this->construireDepuisTableauSQL($objetFormatTableau);
    }

    public function recupererParCoach(string $idcoach): array {
        $sql = "SELECT s." . join(', s.', $this->getNomsColonnes()) . ", p." . join(', p.', $this->getNomsColonnesService()) . " 
            FROM " . $this->getNomTable() . " s 
            JOIN " . $this->getNomTableService() . " p 
            ON p." . $this->getNomClePrimaire() . " = s." . $this->getNomClePrimaire() . " 
            WHERE s.idCoach = :idCoach";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
        $pdoStatement->bindParam(':idCoach', $idcoach);
        $pdoStatement->execute();

        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }

        return $objets;
    }

    public function recuperer(): array {
        $sql = "SELECT s." . join(', s.', $this->getNomsColonnes()) . ", p." . join(', p.', $this->getNomsColonnesService()) . " 
            FROM " . $this->getNomTable() . " s 
            JOIN " . $this->getNomTableService() . " p 
            ON p." . $this->getNomClePrimaire() . " = s." . $this->getNomClePrimaire() . ";";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);

        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }

        return $objets;
    }

    protected function formatTableauSQL(AbstractDataObject $services): array {
        /** @var Service $services */
        return array(
            ":codeServiceTag" => $services->getId(),
            ":nomServiceTag" => $services->getNom(),
            ":descriptionServiceTag" => $services->getDescriptionService(),
            ":prixServiceTag" => $services->getPrixService(),
            ":idUtilisateurTag" => $services->getIdCoach(),
            ":codeJeuTag" => $services->getCodeJeu(),
        );
    }

    abstract function formatTableauSQLServices(AbstractDataObject $services);
}