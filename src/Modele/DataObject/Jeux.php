<?php

namespace App\PlayToWin\Modele\DataObject;

class Jeux extends AbstractDataObject
{
    private string $nomJeu;

    public function __construct(string $nom){
        $this->nom = $nom;
    }

    public function getNomJeu(): string{
        return $this->nomJeu;
    }

}