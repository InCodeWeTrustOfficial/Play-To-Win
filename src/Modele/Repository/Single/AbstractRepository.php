<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\Repository\AbstractMain;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use PDOException;

abstract class AbstractRepository extends AbstractMain {

    abstract protected function getNomClePrimaire() : string;
    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau) : AbstractDataObject;
    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;

    public function recuperer(): ?array {
        $liste = array();

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query('select * from ' . $this->getNomTable());

        foreach ($pdoStatement as $objetFormatTableau) {
            $liste[] = $this->construireDepuisTableauSQL($objetFormatTableau);
        }

        return $liste;
    }

    public function recupererParClePrimaire(string $cle): ?AbstractDataObject {

        $sql = "SELECT * from " . $this->getNomTable() . " WHERE " . $this->getNomClePrimaire() . " = :cleTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "cleTag" => $cle,
        );
        $pdoStatement->execute($values);

        $objetFormatTableau = $pdoStatement->fetch();

        if ($objetFormatTableau == null) {
            MessageFlash::ajouter("warning","$sql $cle.");
            return null;
        }
        return $this->construireDepuisTableauSQL($objetFormatTableau);
    }
    public function ajouter(AbstractDataObject $objet):bool {
        $valide = true;
        try{
            $sql = "INSERT INTO ".$this->getNomTable()." (".join(',',$this->getNomsColonnes()).") VALUES (".join(',',array_keys($this->formatTableauSQL($objet))).")";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);
            $values = $this->formatTableauSQL($objet);
            $pdoStatement->execute($values);

        }catch (PDOException $e){
            MessageFlash::ajouter("danger",$e->getMessage());
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
        }catch (PDOException $e){
            MessageFlash::ajouter("danger",$e->getMessage());
            $valide = false;
        }
        return $valide;
    }
}