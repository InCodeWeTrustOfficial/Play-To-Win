<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\ModeDeJeu;

class ModeDeJeuRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "p_ModesDeJeu";
    }
    public function getNomClePrimaire(): string
    {
        return "nomMode";
    }
    protected function getNomsColonnes(): array
    {
        return array($this->getNomClePrimaire());
    }


    protected function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject
    {
        return new ModeDeJeu($objetFormatTableau[0]);
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        return array(":nomModeTag" => $objet->getNomMode());
    }
}