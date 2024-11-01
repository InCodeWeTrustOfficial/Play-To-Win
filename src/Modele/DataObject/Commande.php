<?php

namespace App\PlayToWin\Modele\DataObject;
use DateTime;

class Commande extends AbstractDataObject {

    private ?int $idCommande;
    private DateTime $dateAchat;
    private string $idUtilisateur;

    /**
     * @param int|null $idCommande
     * @param DateTime $dateAchat
     * @param string $idUtilisateur
     */
    public function __construct(?int $idCommande, DateTime $dateAchat, string $idUtilisateur) {
        $this->idCommande = $idCommande;
        $this->dateAchat = $dateAchat;
        $this->idUtilisateur = $idUtilisateur;
    }

    public function getIdCommande(): ?int {
        return $this->idCommande;
    }

    public function setIdCommande(?int $idCommande): void {
        $this->idCommande = $idCommande;
    }

    public function getDateAchat(): DateTime {
        return $this->dateAchat;
    }

    public function setDateAchat(DateTime $dateAchat): void {
        $this->dateAchat = $dateAchat;
    }

    public function getIdUtilisateur(): string {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(string $idUtilisateur): void {
        $this->idUtilisateur = $idUtilisateur;
    }

}
