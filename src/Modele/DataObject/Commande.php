<?php

namespace App\PlayToWin\Modele\DataObject;
use DateTime;

class Commande extends AbstractDataObject {
    private ?int $idCommande;
    private DateTime $dateAchat;
    private Utilisateur $utilisateur;
    private float $prixTotal;

    public function __construct(
        ?int $idCommande,
        DateTime $dateAchat,
        Utilisateur $utilisateur,
        float $prixTotal
    ) {
        $this->idCommande = $idCommande;
        $this->dateAchat = $dateAchat;
        $this->utilisateur = $utilisateur;
        $this->prixTotal = $prixTotal;
    }

    public function getIdCommande(): ?int {
        return $this->idCommande;
    }

    public function getDateAchat(): DateTime {
        return $this->dateAchat;
    }

    public function getUtilisateur(): Utilisateur {
        return $this->utilisateur;
    }

    public function getNomUtilisateur(): string {
        return $this->utilisateur->getNom();
    }

    public function getIdUtilisateur(): string {
        return $this->utilisateur->getId();
    }

    public function getPrixTotal(): float {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): void {
        $this->prixTotal = $prixTotal;
    }
}
