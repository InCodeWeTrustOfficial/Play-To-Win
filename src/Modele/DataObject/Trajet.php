<?php

namespace App\Covoiturage\Modele\DataObject;

use DateTime;

class Trajet extends AbstractDataObject {

    private ?int $id;
    private string $depart;
    private string $arrivee;
    private DateTime $date;
    private int $prix;
    private Utilisateur $conducteur;
    private bool $nonFumeur;
    private array $passagers;

    public function __construct(
        ?int $id,
        string $depart,
        string $arrivee,
        DateTime $date,
        int $prix,
        Utilisateur $conducteur,
        bool $nonFumeur
    )
    {
        $this->id = $id;
        $this->depart = $depart;
        $this->arrivee = $arrivee;
        $this->date = $date;
        $this->prix = $prix;
        $this->conducteur = $conducteur;
        $this->nonFumeur = $nonFumeur;
        $this->passagers = [];
    }

    public function getPassagers(): array
    {
        return $this->passagers;
    }

    public function setPassagers(array $passagers): void
    {
        $this->passagers = $passagers;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDepart(): string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): void
    {
        $this->depart = $depart;
    }

    public function getArrivee(): string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): void
    {
        $this->arrivee = $arrivee;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getPrix(): int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): void
    {
        $this->prix = $prix;
    }

    public function getConducteur(): Utilisateur
    {
        return $this->conducteur;
    }

    public function setConducteur(Utilisateur $conducteur): void
    {
        $this->conducteur = $conducteur;
    }

    public function isNonFumeur(): bool
    {
        return $this->nonFumeur;
    }

    public function setNonFumeur(bool $nonFumeur): void
    {
        $this->nonFumeur = $nonFumeur;
    }

    public function __toString()
    {
        $nonFumeur = $this->nonFumeur ? " non fumeur" : " ";
        return "
            Le trajet$nonFumeur du {$this->date->format("d/m/Y")} partira de {$this->depart} pour aller à {$this->arrivee} (conducteur: {$this->conducteur->getPrenom()} {$this->conducteur->getNom()}).";
    }


}
