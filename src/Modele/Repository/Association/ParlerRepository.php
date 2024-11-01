<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
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

    protected function formatTableauSQL(array $objet): array
    {
        return array(":cle1Tag" => $objet[0],":cle2Tag" => $objet[1]);
    }

    public function recupererUtilisateurs(string $cle):?array{
        return $this->recupererListeParObjetClePrimaire((new LangueRepository()),array((new UtilisateurRepository())),$cle);
    }

    public function recupererLangues(string $cle):?array{
        $array = [];
        $q =  $this->recupererListeParObjetClePrimaire((new UtilisateurRepository()),array((new LangueRepository())),$cle);
        if ($q != null) {
            foreach ($q as $objet) {
                $array[] = $objet[0];
            }
        }
        return $array;

    }


}