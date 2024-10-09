<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use PDOException;

abstract class AbstractRepository {


    protected abstract function getNomTable() : string;
    protected abstract function getNomClePrimaire() : string;
    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function getNomsColonnes() : array;
    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;



    public function recuperer(): array {
        $liste = array();

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query('select * from ' . $this->getNomTable());

        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableauSQL($objetFormatTableau);

        }
        return $objets;
    }

    public function recupererParClePrimaire(string $cle): ?AbstractDataObject
    {
        $sql = "SELECT * from ".$this->getNomTable()." WHERE ".$this->getNomClePrimaire()." = :cleTag";

        // Préparation de la requête
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "cleTag" => $cle,
        );
        $pdoStatement->execute($values);

        $objetFormatTableau = $pdoStatement->fetch();

        if ($objetFormatTableau == null) {
            return null;
        }
        return $this->construireDepuisTableauSQL($objetFormatTableau);
    }

    public function supprimer(string $cle) : bool{
        $valide = true;
        try{
            $sql = "DELETE FROM ".$this->getNomTable()." WHERE ".$this->getNomClePrimaire()." = :cleTag";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = array("cleTag" => $cle);

            $pdoStatement->execute($values);

        }catch(PDOException){
            $valide = false;
        }
        return $valide;
    }

    public function ajouter(AbstractDataObject $objet):bool {
        $valide = true;
        try{
            $sql = "INSERT INTO ".$this->getNomTable()." (".join(',',$this->getNomsColonnes()).") VALUES (".join(',',array_keys($this->formatTableauSQL($objet))).")";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = $this->formatTableauSQL($objet);
            $pdoStatement->execute($values);
        }catch (PDOException){
            $valide = false;
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
}