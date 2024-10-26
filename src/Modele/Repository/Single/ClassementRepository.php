<?php

namespace App\Covoiturage\Modele\Repository\Single;

use App\playToWin\Modele\DataObject\Classement;
use App\PlayToWin\Modele\Repository\Single\AbstractRepository;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;

class ClassementRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "p_Classement";
    }

    protected function getNomClePrimaire(): string
    {
        return "idClassement";
    }

    protected function getNomsColonnes(): array
    {
        return ["idClassement", "nomClassement","divisionClassement"];
    }

    protected function formatTableauSQL(AbstractDataObject $l): array
    {
        /** @var Classement $c */
        return array(
            ":idClassementTag" => $c->getIdClassement(),
            ":nomClassementTag" => $c->getNomClassement(),
            ":divisionClassementTag" => $c->getDivisionClassement()
        );
    }

    protected function construireDepuisTableauSQL(array $classementTableau): Classement
    {
        return new Classement(
            $classementTableau['idClassement'],
            $classementTableau['nomClassement'],
            $classementTableau['divisionClassement']
        );
    }
}