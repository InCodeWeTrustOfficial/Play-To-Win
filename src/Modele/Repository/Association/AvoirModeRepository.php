<?php

namespace App\PlayToWin\Modele\Repository\Association;


use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\ModeDeJeuRepository;

class AvoirModeRepository extends AbstractAssociationRepository {

    protected function getNomsClePrimaire(): array
    {
        return array((new ModeDeJeuRepository())->getNomClePrimaire(),(new JeuRepository())->getNomClePrimaire());
    }

    protected function formatTableauSQL(array $objet): array
    {
        return array(
          ":cle1Tag" => $objet[0],
          ":cle2Tag" => $objet[1]
        );
    }

    protected function getNomTable(): string
    {
        return "p_avoirMode";
    }

    protected function getNomsColonnes(): array
    {
        return $this->getNomsClePrimaire();
    }

    public function recuperer(): ?array
    {
        return parent::recupererSousListe(array((new ModeDeJeuRepository()),(new JeuRepository())));
    }
}