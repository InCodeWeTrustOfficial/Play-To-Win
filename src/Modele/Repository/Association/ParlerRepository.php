<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Modele\Repository\Single\LangueRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class ParlerRepository extends AbstractAssociationRepository {

    protected function getNomsClePrimaire(): array
    {
        return array((new UtilisateurRepository())->getNomClePrimaire(),(new LangueRepository())->getNomClePrimaire());
    }

    protected function getNomTable(): string
    {
        return "p_Parler";
    }

    protected function getNomsColonnes(): array
    {
        return $this->getNomsClePrimaire();
    }

    public function recupererUtilisateurs(string $cle):?array{
        return $this->recupererListeParObjetClePrimaire((new LangueRepository()),(new UtilisateurRepository()),$cle);
    }
    public function recupererLangues(string $cle):?array{
        return $this->recupererListeParObjetClePrimaire((new UtilisateurRepository()),(new LangueRepository()),$cle);
    }
}