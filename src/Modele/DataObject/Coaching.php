<?php

namespace App\Covoiturage\Modele\DataObject;

class Coaching extends Services {

    public function getTypeService(): string {
        return "Coaching";
    }

    private int $duree;

    /**
     * @param string $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param int $prix
     * @param string $coach
     * @param string $nomJeu
     * @param int $duree
     */
    public function __construct(
        string $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        int $prix,
        string $coach,
        string $nomJeu,
        int $duree
    ) {
        parent::__construct($codeService, $nomService, $descriptionService, $prixService, $prix, $coach, $nomJeu);
        $this->duree = $duree;
    }

    public function getDuree(): int {
        return $this->duree;
    }

    public function setDuree(int $duree): void {
        $this->duree = $duree;
    }
}