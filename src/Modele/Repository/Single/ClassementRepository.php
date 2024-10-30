<?php

namespace App\Covoiturage\Modele\Repository\Single;

use App\playToWin\Modele\DataObject\Classement;
use App\PlayToWin\Modele\Repository\Single\AbstractRepository;
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
        return [$this->getNomClePrimaire(), "nomClassement","divisionClassement"];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Classement $objet */
        return array(
            ":idClassementTag" => $objet->getIdClassement(),
            ":nomClassementTag" => $objet->getNomClassement(),
            ":divisionClassementTag" => $objet->getDivisionClassement()
        );
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): Classement
    {
        return new Classement(
            $objetFormatTableau['idClassement'],
            $objetFormatTableau['nomClassement'],
            $objetFormatTableau['divisionClassement']
        );
    }
}