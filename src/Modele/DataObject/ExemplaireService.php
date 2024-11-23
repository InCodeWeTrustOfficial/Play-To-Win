<?php

namespace App\PlayToWin\Modele\DataObject;

use App\PlayToWin\Modele\Repository\Single\ExemplaireServiceRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class ExemplaireService extends AbstractDataObject {

    private ?int $idExemplaire;
    private string $etatService;
    private string $sujet;
    private string $codeService;
    private string $idCommande;

    /**
     * @param int|null $idExemplaire
     * @param string $etatService
     * @param string $sujet
     * @param string $codeService
     * @param string $idCommande
     */
    public function __construct(?int $idExemplaire, string $etatService, string $sujet, string $codeService, string $idCommande) {
        $this->idExemplaire = $idExemplaire;
        $this->etatService = $etatService;
        $this->sujet = $sujet;
        $this->codeService = $codeService;
        $this->idCommande = $idCommande;
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

    public function getCodeService(): string {
        return $this->codeService;
    }

    public function setCodeService(string $codeService): void {
        $this->codeService = $codeService;
    }

    public function getIdCommande(): string {
        return $this->idCommande;
    }

    public function setIdCommande(string $idCommande): void {
        $this->idCommande = $idCommande;
    }
    
    public function getService(string $codeservice): ?string {
        $service = (new ExemplaireServiceRepository())->getService($this->codeService);
        return $service->getControleur();
    }
    
}
