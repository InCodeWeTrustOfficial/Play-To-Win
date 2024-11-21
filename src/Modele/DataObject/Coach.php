<?php

namespace App\PlayToWin\Modele\DataObject;

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
    public function getBannierePath(): string
    {
        $ext = "";
        if(file_exists(__DIR__ ."/../../../".$this::$pathBannieres.$this->getId().".png")){
            $ext = ".png";
        } else if (file_exists(__DIR__ ."/../../../".$this::$pathBannieres.$this->getId().".jpg")){
            $ext = ".jpg";
        } else{
        }
        return $this::$pathBannieres.$this->getId().$ext;
    }

    public function getControleur(): string {
        return "coach";
    }
}