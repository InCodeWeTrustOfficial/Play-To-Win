<?php

namespace App\PlayToWin\Modele\DataObject;

use App\PlayToWin\Lib\LogistiqueImage;
use App\PlayToWin\Lib\MessageFlash;
use DateTime;

class Coach extends Utilisateur {
    private string $biographie;
    private static string $pathBannieres = "ressources/img/uploads/coach/bannieres/";

    public function __construct(Utilisateur $utilisateur, string $biographie) {
        parent::__construct($utilisateur->getId(),$utilisateur->getNom(),$utilisateur->getPrenom(),$utilisateur->getPseudo(),$utilisateur->getEmail(),$utilisateur->getEmailAValider(),$utilisateur->getNonce(),$utilisateur->getDateNaissance(),$utilisateur->getMdpHache(),$utilisateur->isAdmin());
        $this->biographie = $biographie;
    }
    public function getBiographie(): string
    {
        return $this->biographie;
    }
    public function setBiographie(string $biographie): void
    {
        $this->biographie = $biographie;
    }

    public function getPathBannieresBrut(): string{
        return self::$pathBannieres;
    }

    public function getBannierePath(): string {

        return (new LogistiqueImage(self::$pathBannieres))->getCheminComplet($this->getId());

    }

    public function getControleur(): string {
        return "coach";
    }
}