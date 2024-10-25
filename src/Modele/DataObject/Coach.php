<?php

namespace App\PlayToWin\Modele\DataObject;

use DateTime;

class Coach extends Utilisateur {
    private string $biographie;

    public function __construct(Utilisateur $utilisateur, string $biographie) {
        parent::__construct($utilisateur->getId(),$utilisateur->getNom(),$utilisateur->getPrenom(),$utilisateur->getPseudo(),$utilisateur->getEmail(),$utilisateur->getEmailAValider(),$utilisateur->getNonce(),$utilisateur->getDateNaissance(),$utilisateur->getMdpHache(),$utilisateur->isAdmin());
        $this->biographie = $biographie;
    }

    public function getBiographie(): string {
        return $this->biographie;
    }

    public function setBiographie(string $biographie): void {
        $this->biographie = $biographie;
    }

    public function getBanniere(): string {
        return "img/uploads/coach/banniere/".$this->getId().".png";
    }
}