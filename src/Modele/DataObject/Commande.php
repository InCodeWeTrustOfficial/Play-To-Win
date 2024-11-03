<?php

namespace App\PlayToWin\Modele\DataObject;
use DateTime;

class Commande extends AbstractDataObject {
    private ?int $idCommande;
    private DateTime $dateAchat;
    private string $idUtilisateur;
    private float $prixTotal;

    public function __construct(
        ?int $idCommande,
        DateTime $dateAchat,
        string $idUtilisateur,
        float $prixTotal
    ) {
        $this->idCommande = $idCommande;
        $this->dateAchat = $dateAchat;
        $this->idUtilisateur = $idUtilisateur;
        $this->prixTotal = $prixTotal;
    }

    public function getIdCommande(): ?int {
        return $this->idCommande;
    }

    public function getDateAchat(): DateTime {
        return $this->dateAchat;
    }

    public function getIdUtilisateur(): string {
        return $this->idUtilisateur;
    }

    public function getPrixTotal(): float {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): void {
        $this->prixTotal = $prixTotal;
    }
}
