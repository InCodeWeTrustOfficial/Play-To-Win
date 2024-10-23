<?php

namespace App\PlayToWin\Modele\Repository;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Coach;

class CoachRepository extends AbstractRepository {
    protected function getNomTable(): string {
        return "p_Coachs";
    }

    protected function getNomClePrimaire(): string {
        return "idCoach";
    }
    protected function getNomsColonnes(): array {
        return array(self::getNomClePrimaire(),"biographieCoach","banniereCoach");
    }

    protected function formatTableauSQL(AbstractDataObject $coach): array {
        /** @var Coach $coach */
        return array(
            ":idTag" => $coach->getId(),
            ":biographieTag" => $coach->getBiographie(),
            ":banniereTag" => $coach->getBanniere(),
        );
    }
    protected function construireDepuisTableauSQL(array $coachFormatTableau): AbstractDataObject
    {
        return new Coach($coachFormatTableau[0],$coachFormatTableau[1],$coachFormatTableau[2]);
    }
}