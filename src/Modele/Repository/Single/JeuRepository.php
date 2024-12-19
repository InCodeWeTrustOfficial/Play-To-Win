<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Jeu;

class JeuRepository extends AbstractRepository
{
    protected function getNomTable(): string{
        return "p_Jeux";
    }

    public function getNomClePrimaire(): string
    {
        return "codeJeu";
    }

    protected function getNomsColonnes(): array
    {
        return array($this->getNomClePrimaire(), "nomjeu");
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Jeu $objet */
        return array(
            ":codeJeuTag" => $objet->getCodeJeu(),
            ":nomJeuTag" => $objet->getNomJeu()
        );
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau) : Jeu {
        return new Jeu($objetFormatTableau["codeJeu"],$objetFormatTableau["nomJeu"]);
    }
}