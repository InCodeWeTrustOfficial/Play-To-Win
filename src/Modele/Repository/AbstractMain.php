<?php

namespace App\PlayToWin\Modele\Repository;

use App\PlayToWin\Lib\MessageFlash;
use PDOException;

abstract class AbstractMain {

    protected abstract function getNomTable() : string;
    protected abstract function getNomsColonnes() : array;

    public function supprimer(string $cle) : bool{
        $valide = true;
        try{
            $sql = "DELETE FROM ".$this->getNomTable()." WHERE ".$this->getNomClePrimaire()." = :cleTag";

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = array("cleTag" => $cle);

            $pdoStatement->execute($values);

        }catch(PDOException $e){
            MessageFlash::ajouter("danger", $e->getMessage());
            $valide = false;
        }
        return $valide;
    }

}