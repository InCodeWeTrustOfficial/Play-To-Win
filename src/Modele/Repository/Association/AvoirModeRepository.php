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

    public function recupererMap() : array {
        $liste = parent::recuperer();

        $rep = array();

        foreach ($liste as $elem) {
            $rep[$elem[1]->getCodeJeu()][] = $elem[0];
        }
        return $rep;
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): mixed
    {
        return array((new ModeDeJeuRepository())->recupererParClePrimaire($objetFormatTableau[0]),
                     (new JeuRepository())->recupererParClePrimaire($objetFormatTableau[1]));
    }


}