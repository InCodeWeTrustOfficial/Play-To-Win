<?php

namespace App\Covoiturage\Modele\DataObject;

abstract class Services extends AbstractDataObject {

    private string $codeService;
    private string $nomService;
    private string $descriptionService;
    private float $prixService;
    private float $prix;
    private int $coach;
    private string $nomJeu;

    /**
     * @param string $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param float $prix
     * @param int $coach
     * @param string $nomJeu
     */
    public function __construct(
        string $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        float $prix,
        int $coach,
        string $nomJeu
    ) {
        $this->codeService = $codeService;
        $this->nomService = $nomService;
        $this->descriptionService = $descriptionService;
        $this->prixService = $prixService;
        $this->prix = $prix;
        $this->coach = $coach;
        $this->nomJeu = $nomJeu;
    }

    // Getters and setters...

    public function getCodeService(): string {
        return $this->codeService;
    }

    public function setCodeService(string $codeService): void {
        $this->codeService = $codeService;
    }

    public function getNomService(): string {
        return $this->nomService;
    }

    public function setNomService(string $nomService): void {
        $this->nomService = $nomService;
    }

    public function getDescriptionService(): string {
        return $this->descriptionService;
    }

    public function setDescriptionService(string $descriptionService): void {
        $this->descriptionService = $descriptionService;
    }

    public function getPrixService(): float {
        return $this->prixService;
    }

    public function setPrixService(float $prixService): void {
        $this->prixService = $prixService;
    }

    public function getPrix(): float {
        return $this->prix;
    }

    public function setPrix(float $prix): void {
        $this->prix = $prix;
    }

    public function getCoach(): int {
        return $this->coach;
    }

    public function setCoach(int $coach): void {
        $this->coach = $coach;
    }

    public function getNomJeu(): string {
        return $this->nomJeu;
    }

    public function setNomJeu(string $nomJeu): void {
        $this->nomJeu = $nomJeu;
    }
}
