<?php

namespace App\PlayToWin\Modele\DataObject;

class Jeu extends AbstractDataObject
{
    private string $codeJeu;
    private string $nomJeu;

    private static string $pathLogo = "ressources/img/jeux/";

    public function __construct(string $codeJeu,string $nom){
        $this->codeJeu = $codeJeu;
        $this->nomJeu = $nom;
    }

    public function setCodeJeu(string $codeJeu): void
    {
        $this->codeJeu = $codeJeu;
    }

    public function setNomJeu(string $nomJeu): void
    {
        $this->nomJeu = $nomJeu;
    }

    public function getCodeJeu(): string{
        return $this->codeJeu;
    }

    public function getNomJeu(): string{
        return $this->nomJeu;
    }

    public function getPathLogo(): string{
        return self::$pathLogo.$this->codeJeu.".png";
    }

}