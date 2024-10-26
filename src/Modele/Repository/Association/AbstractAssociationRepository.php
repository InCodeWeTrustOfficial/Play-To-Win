<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\Repository\AbstractMain;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\Single\AbstractRepository;
use PDOException;

/**
 * Cette classe s'adresse aux associations 2-aires
 */
abstract class AbstractAssociationRepository extends AbstractMain {

    protected abstract function getNomsClePrimaire(): array;
    protected function recupererListeParObjetClePrimaire(AbstractRepository $repo, AbstractRepository $repo2, string $cle): ?array {

        $sql = "select ".$repo2->getNomClePrimaire()." from ".$this->getNomTable()." where ".$repo->getNomClePrimaire()." = :cleTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array("cleTag" => $cle);

        $pdoStatement->execute($values);

        $objetsFormatTableau = $pdoStatement->fetchAll();

        $array = array();

        if($objetsFormatTableau == null) {
            return null;
        } else{
            foreach ($objetsFormatTableau as $objet) {
                $array[] = $repo2->recupererParClePrimaire($objet[0]);
            }
        }
        return $array;
    }
    public function supprimerTuple(string $cle1, string $cle2):bool{
        $valide = true;
        try{

            $sql = "delete from ".$this->getNomTable()." where ".$this->getNomsClePrimaire()[0]." = :cle1Tag and ".$this->getNomsClePrimaire()[1]." = :cle2Tag";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = array("cle1Tag" => $cle1, "cle2Tag" => $cle2);

            $pdoStatement->execute($values);

        }catch(PDOException $e){
            MessageFlash::ajouter("danger",$e->getMessage());
            $valide = false;
        }
        return $valide;
    }

    public function ajouterTuple(string $cle1, string $cle2):bool{
        $valide = true;
        try{
            $sql = "insert into ".$this->getNomTable()." (".join(',',$this->getNomsColonnes()).") values (:cle1Tag, :cle2Tag)";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = array("cle1Tag" => $cle1, "cle2Tag" => $cle2);

            $pdoStatement->execute($values);

        }catch(PDOException $e){
            MessageFlash::ajouter("danger",$e->getMessage());
            $valide = false;
        }
        return $valide;
    }

    public function existeTuple(string $cle1, string $cle2):bool{
        $existe = true;
        $sql = "select * from ".$this->getNomTable()." where ".$this->getNomsClePrimaire()[0]." = :cle1Tag and ".$this->getNomsClePrimaire()[1]." = :cle2Tag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array("cle1Tag" => $cle1, "cle2Tag" => $cle2);

        $pdoStatement->execute($values);

        $objetsFormatTableau = $pdoStatement->fetch();

        if($objetsFormatTableau == null) {
            $existe = false;
        }
        return $existe;
    }
    private function autreNomClePrimaire(string $mauvaiseCle) : string{
        $array = $this->getNomsClePrimaire();
        unset($array[$mauvaiseCle]);
        return end($array);
    }

}