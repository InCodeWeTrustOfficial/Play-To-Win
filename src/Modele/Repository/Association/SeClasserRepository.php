<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Modele\Repository\Single\ClassementRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class SeClasserRepository extends AbstractAssociationRepository {

    protected function getNomsClePrimaire(): array
    {
        return array((new ClassementRepository())->getNomClePrimaire(),(new JeuRepository())->getNomClePrimaire());
    }

    protected function formatTableauSQL(array $objet): array
    {
        return array(
          "cle1Tag" => $objet[0],
          "cle2Tag" => $objet[1],
          "cle3Tag" => $objet[2],
          "cle4Tag" => $objet[3],
          "cle5Tag" => $objet[4],
          "cle6Tag" => $objet[5],
        );
    }

    protected function getNomTable(): string
    {
        return "p_seClasser";
    }

    protected function getNomsColonnes(): array
    {
        $cp = $this->getNomsClePrimaire();
        return array($cp[0], $cp[1],"place","eloMin","eloMax","cumulElo");
    }

    public function recuperer() : array{
        return parent::recuperer();
    }
}