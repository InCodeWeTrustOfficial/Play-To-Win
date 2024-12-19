<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;

class CoachRepository extends AbstractRepository {
    protected function getNomTable(): string {
        return "p_Coachs";
    }

    public function getNomClePrimaire(): string {
        return "idCoach";
    }
    protected function getNomsColonnes(): array {
        return array(self::getNomClePrimaire(),"biographieCoach");
    }

    protected function formatTableauSQL(AbstractDataObject $coach): array {
        /** @var Coach $coach */
        return array(
            ":idTag" => $coach->getId(),
            ":biographieTag" => $coach->getBiographie()
        );
    }
    protected function construireDepuisTableauSQL(array $coachFormatTableau): AbstractDataObject{
        return new Coach((new UtilisateurRepository())->recupererParClePrimaire($coachFormatTableau[0]) ,$coachFormatTableau[1]);
    }

    public function estCoach(string $user): bool{
        $sql = "select count(*) from ".$this->getNomTable()." c where c.".$this->getNomClePrimaire()." = :idTag;";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array("idTag" => $user);

        $pdoStatement->execute($values);

        return $pdoStatement->fetchColumn() == 1;
    }
}