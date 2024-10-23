<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;

abstract class ServiceRepository extends AbstractRepository{

    abstract function getNomTableService(): string;
    abstract function getNomsColonnesService(): array;

    protected function getNomTable(): string {
        return "p_Services";
    }
    protected function getNomClePrimaire(): string {
        return "codeService	";
    }
    protected function getNomsColonnes(): array {
        return ["codeService", "nomService", "descriptionService", "prixService", "idCoach","nomJeu"];
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
        try {
            // Insertion dans la table p_Services
            $sqlService = "INSERT INTO " . $this->getNomTable() . " (" . join(',', $this->getNomsColonnes()) . ") 
                       VALUES (" . join(',', array_keys($this->formatTableauSQL($objet))) . ")";

            $pdoStatementService = ConnexionBaseDeDonnees::getPdo()->prepare($sqlService);
            $valuesService = $this->formatTableauSQL($objet);
            $pdoStatementService->execute($valuesService);

            // Récupération de codeService du dernier service inséré
            $codeService = ConnexionBaseDeDonnees::getPdo()->lastInsertId();

            // Insertion dans la table p_AnalysesVideo avec l'ID récupéré
            $valuesAnalyse = $this->formatTableauSQLServices($objet);
            // Ajout de la valeur du codeService dans les valeurs pour l'analyse
            $valuesAnalyse[":codeServiceTag"] = $codeService;

            $sqlAnalyse = "INSERT INTO " . $this->getNomTableService() . " (" . join(',', $this->getNomsColonnesService()) . ") 
                       VALUES (" . join(',', array_keys($valuesAnalyse)) . ")";

            $pdoStatementAnalyse = ConnexionBaseDeDonnees::getPdo()->prepare($sqlAnalyse);
            $pdoStatementAnalyse->execute($valuesAnalyse);

        } catch (PDOException $e) {
            $valide = false;
            echo "Erreur lors de l'ajout : " . $e->getMessage();
        }
        return $valide;
    }

    public function mettreAJour(AbstractDataObject $objet):bool {
        $valide = true;
        try{
            $nomCol = $this->getNomsColonnes();
            unset($nomCol[0]);
            $nomTag = array_keys($this->formatTableauSQL($objet));
            unset($nomTag[0]);

            $args = "";

            for($i = 1; $i<=count($nomCol);$i++){
                $args = $args . $nomCol[$i] .' = ' . $nomTag[$i];
                if($i != count($nomCol)){
                    $args = $args . ',';
                }
            }

            $sql = "UPDATE ".$this->getNomTable()." SET ".$args." WHERE ".$this->getNomClePrimaire()." = ".array_keys($this->formatTableauSQL($objet))[0];

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = $this -> formatTableauSQL($objet);
            $pdoStatement->execute($values);
        }catch (PDOException){
            $valide = false;
        }
        return $valide;
    }

    public function recupererParClePrimaire(string $cle): ?AbstractDataObject {
        // Requette sql pour récuperer les données
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

    public function recuperer(): array {
        $liste = array();

        // Requette sql pour récuperer les données
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
        /** @var Services $services */
        return array(
            ":codeServiceTag" => $services->getCodeService(),
            ":nomServiceTag" => $services->getNomService(),
            ":descriptionServiceTag" => $services->getDescriptionService(),
            ":prixServiceTag" => $services->getPrixService(),
            ":idUtilisateurTag" => $services->getCoach(),
            ":nomJeuTag" => $services->getNomJeu(),
        );
    }

    abstract function formatTableauSQLServices(AbstractDataObject $services);
}