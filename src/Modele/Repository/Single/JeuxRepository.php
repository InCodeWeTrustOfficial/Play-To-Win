<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Jeux;

class JeuxRepository extends AbstractRepository
{
    protected function getNomTable(): string{
        return "p_Jeux";
    }

    public function getNomClePrimaire(): string
    {
        return "nomJeu";
    }

    protected function getNomsColonnes(): array
    {
        return ["nomJeu"];
    }

    protected function formatTableauSQL(AbstractDataObject $j): array
    {
        /** @var Jeux $j */
        return array(
            ":nomJeuTag" => $j->getNomJeu()
        );
    }

    protected function construireDepuisTableauSQL(array $jeuTableau) : Jeux {
        return new Jeux($jeuTableau["nomJeu"]);
    }
}