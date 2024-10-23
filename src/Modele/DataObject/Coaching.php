<?php

namespace App\Covoiturage\Modele\DataObject;

class Coaching extends Services {

    public function getTypeService(): string {
        return "coaching";
    }

    private int $duree;

    /**
     * @param ?int $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param string $coach
     * @param string $nomJeu
     * @param int $duree
     */
    public function __construct(
        ?int $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        string $coach,
        string $nomJeu,
        int $duree
    ) {
        parent::__construct(
            $codeService,
            $nomService,
            $descriptionService,
            $prixService,
            $coach,
            $nomJeu
        );
        $this->duree = $duree;
    }

    public function getDuree(): int {
        return $this->duree;
    }

    public function setDuree(int $duree): void {
        $this->duree = $duree;
    }
}