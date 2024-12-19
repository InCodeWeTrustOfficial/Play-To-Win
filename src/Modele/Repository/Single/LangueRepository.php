<?php

namespace App\PlayToWin\Modele\Repository\Single;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Langue;

class LangueRepository extends AbstractRepository
{
    protected function getNomTable(): string{
        return "p_Langues";
    }

    public function getNomClePrimaire(): string
    {
        return "code_alpha";
    }

    protected function getNomsColonnes(): array
    {
        return ["code_alpha","nom"];
    }

    protected function formatTableauSQL(AbstractDataObject $l): array
    {
        /** @var Langue $l */
        return array(
            ":codeAlphaTag" => $l->getCodeAlpha(),
            ":nomTag" => $l->getNom()
        );
    }

    protected function construireDepuisTableauSQL(array $langueTableau) : Langue {
        return new Langue(
            $langueTableau["code_alpha"],
            $langueTableau["nom"]
        );
    }
}