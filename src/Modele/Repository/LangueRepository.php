<?php

namespace App\Covoiturage\Modele\Repository;
use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Langue;

class LangueRepository extends AbstractRepository
{
    protected function getNomTable(): string{
        return "p_Langues";
    }

    protected function getNomClePrimaire(): string
    {
        return "code_alpha";
    }

    protected function getNomsColonnes(): array
    {
        return ["code_alpha","nom","drapeau"];
    }

    protected function formatTableauSQL(AbstractDataObject $l): array
    {
        /** @var Langue $l */
        return array(
            ":codeAlphaTag" => $l->getCodeAlpha(),
            ":nomTag" => $l->getNom(),
            ":drapeauTag" => $l->getDrapeau()
        );
    }

    protected function construireDepuisTableauSQL(array $langueTableau) : Langue {
        return new Langue(
            $langueTableau["code_alpha"],
            $langueTableau["nom"],
            $langueTableau["drapeau"]
        );
    }
}