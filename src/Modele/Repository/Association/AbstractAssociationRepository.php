<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\Repository\AbstractMain;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\Single\AbstractRepository;
use PDOException;

/**
 * Cette classe s'adresse aux associations 2-aires
 */
abstract class AbstractAssociationRepository extends AbstractMain {

    protected abstract function getNomsClePrimaire(): array;
    protected abstract function formatTableauSQL(array $objet): array;

    protected function recupererSousListe(array $repo): ?array {

        /** @var AbstractRepository[] $repo */

        $liste = parent::recuperer();
        $array = array();
        foreach ($liste as $tuple) {
            $line = array();
            for($i = 0; $i< count($repo);$i++){
                $line[] = $repo[$i]->recupererParClePrimaire($tuple[$i]);
            }
            $array[] = $line;
        }
        return $array;
    }

    protected function recupererListeParObjetClePrimaire(AbstractRepository $repo, array $repo2, string $cle): ?array {

        /** @var AbstractRepository[] $repo2 */

        $nomsCles = "";
        for($i = 0; $i < count($repo2); $i++){
            $nomsCles .= $repo2[$i]->getNomClePrimaire();
            if($i < count($repo2) - 1){
                $nomsCles .= ", ";
            }
        }

        $sql = "select ".$nomsCles." from ".$this->getNomTable()." where ".$repo->getNomClePrimaire()." = :cleTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array("cleTag" => $cle);

        $pdoStatement->execute($values);

        $objetsFormatTableau = $pdoStatement->fetchAll();

        $array = array();

        if($objetsFormatTableau == null) {
            return null;
        } else{
            foreach ($objetsFormatTableau as $objet) {
                $line = [];
                for($i = 0; $i < count($repo2);$i++){
                    $line[] = $repo2[$i]->recupererParClePrimaire($objet[$i]);
                }
                $array[] = $line;
            }
        }
        return $array;
    }
    public function supprimerTuple(array $cles):bool{
        $valide = true;
        try{
            $sup = $this->recupererTags($cles);

            $sql = "delete from ".$this->getNomTable().$sup;

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = $this->formatTableauSQL($cles, false);

            $pdoStatement->execute($values);

        }catch(PDOException $e){
            MessageFlash::ajouter("danger",$e->getMessage());
            $valide = false;
        }
        return $valide;
    }

    public function ajouterTuple(array $cles):bool{
        $valide = true;
        try{
            $sql = "insert into ".$this->getNomTable()." (".join(',',$this->getNomsColonnes()).") VALUES (".join(',',array_keys($this->formatTableauSQL($cles))).")";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = $this->formatTableauSQL($cles);

            $pdoStatement->execute($values);

        }catch(PDOException $e){
            MessageFlash::ajouter("danger",$sql."|".$e->getMessage());
            $valide = false;
        }
        return $valide;
    }

    public function existeTuple(array $cles):bool{
        $existe = true;

        $sup = $this->recupererTags($cles);

        $sql = "select * from ".$this->getNomTable().$sup;

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = $this->formatTableauSQL($cles, false);

        $pdoStatement->execute($values);

        $objetsFormatTableau = $pdoStatement->fetch();

        if($objetsFormatTableau == null) {
            $existe = false;
        }
        return $existe;
    }

    private function recupererTags(array $cles):string{
        $sup = " where";
        for ($i = 0; $i<count($cles); $i++) {
            $sup.= " ".$this->getNomsClePrimaire()[$i]." = :cle".($i+1)."Tag";
            if($i < count($cles)-1){
                $sup.= " and";
            }
        }
        $sup .= ";";
        return $sup;
    }
    private function autreNomClePrimaire(string $mauvaiseCle) : string{
        $array = $this->getNomsClePrimaire();
        unset($array[$mauvaiseCle]);
        return end($array);
    }

}