<?php

namespace App\PlayToWin\Modele\DataObject;

use App\PlayToWin\Modele\Repository\Single\ExemplaireServiceRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class ExemplaireService extends AbstractDataObject {

    private ?int $idExemplaire;
    private string $etatService;
    private string $sujet;
    private Service $service;
    private Commande $commande;

    /**
     * @param int|null $idExemplaire
     * @param string $etatService
     * @param string $sujet
     * @param Service $service
     * @param Commande $commande
     */
    public function __construct(
        ?int $idExemplaire,
        string $etatService,
        string $sujet,
        Service $service,
        Commande $commande)
    {
        $this->idExemplaire = $idExemplaire;
        $this->etatService = $etatService;
        $this->sujet = $sujet;
        $this->service = $service;
        $this->commande = $commande;
    }

    public function getIdExemplaire(): ?int {
        return $this->idExemplaire;
    }

    public function setIdExemplaire(?int $idExemplaire): void {
        $this->idExemplaire = $idExemplaire;
    }

    public function getEtatService(): string {
        return $this->etatService;
    }

    public function setEtatService(string $etatService): void {
        $this->etatService = $etatService;
    }

    public function getSujet(): string {
        return $this->sujet;
    }

    public function setSujet(string $sujet): void {
        $this->sujet = $sujet;
    }

    public function getService(): Service {
        return $this->service;
    }

    public function getCodeService(): int {
        return $this->service->getId();
    }

    public function getIdCommande(): string {
        return $this->commande->getIdCommande();
    }

    public function getCommande(): Commande {
        return $this->commande;
    }

    public function getControleurService(): ?string {
        return $this->service->getControleur();
    }
    
}
