<?php

namespace App\PlayToWin\Modele\DataObject;

class Jeu extends AbstractDataObject
{
    private string $nomJeu;

    private static string $pathLogo = "ressources/img/jeux/";

    public function __construct(string $nom){
        $this->nom = $nom;
    }

    public function getNomJeu(): string{
        return $this->nomJeu;
    }

    public function getPathLogo(): string{
        return self::$pathLogo.$this->nomJeu.".png";
    }

}