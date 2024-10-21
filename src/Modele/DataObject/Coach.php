<?php

namespace App\Covoiturage\Modele\DataObject;

use DateTime;

class Coach extends Utilisateur {
    private string $biographie;
    private string $banniere;

    public function __construct(Utilisateur $utilisateur, string $biographie, string $baniere) {
        parent::__construct($utilisateur->getId(),$utilisateur->getNom(),$utilisateur->getPrenom(),$utilisateur->getPseudo(),$utilisateur->getEmail(),$utilisateur->getEmailAValider(),$utilisateur->getNonce(),$utilisateur->getDateNaissance(),$utilisateur->getMdpHache(),$utilisateur->isAdmin(),$utilisateur->getAvatarPath(),$utilisateur->getLangue());
        $this->biographie = $biographie;
        $this->banniere = $baniere;
    }
    public function getBiographie(): string
    {
        return $this->biographie;
    }
    public function setBiographie(string $biographie): void
    {
        $this->biographie = $biographie;
    }
    public function getBanniere(): string
    {
        return $this->banniere;
    }
    public function setBanniere(string $baniere): void
    {
        $this->banniere = $baniere;
    }
}