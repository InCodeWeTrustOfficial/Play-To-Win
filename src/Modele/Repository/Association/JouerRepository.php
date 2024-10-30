<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\Covoiturage\Modele\Repository\Single\ClassementRepository;
use App\PlayToWin\Modele\DataObject\ModeDeJeu;
use App\PlayToWin\Modele\Repository\Single\JeuxRepository;
use App\PlayToWin\Modele\Repository\Single\ModeDeJeuRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class JouerRepository extends AbstractAssociationRepository {

    protected function getNomsClePrimaire(): array {
        return array((new JeuxRepository())->getNomClePrimaire(),(new UtilisateurRepository())->getNomClePrimaire(),(new ModeDeJeuRepository())->getNomClePrimaire());
    }

    protected function getNomTable(): string {
        return "p_jouer";
    }

    protected function getNomsColonnes(): array {
        $cles = $this->getNomsClePrimaire();
        return array($cles[0],$cles[1],$cles[2],"idClassement");
    }
}