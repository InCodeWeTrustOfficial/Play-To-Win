<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\Classement;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;

class ClassementRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "p_Classements";
    }

    public function getNomClePrimaire(): string
    {
        return "idClassement";
    }

    protected function getNomsColonnes(): array
    {
        return [$this->getNomClePrimaire(), "nomClassement","divisionClassement","acronyme"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Classement $objet */
        return array(
            ":idClassementTag" => $objet->getIdClassement(),
            ":nomClassementTag" => $objet->getNomClassement(),
            ":divisionClassementTag" => $objet->getDivisionClassement(),
            ":acronymeTag" => $objet->getAcronyme()
        );
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Classement
    {
        return new Classement(
            $objetFormatTableau['idClassement'],
            $objetFormatTableau['nomClassement'],
            $objetFormatTableau['divisionClassement'],
            $objetFormatTableau['acronyme']
        );
    }
}