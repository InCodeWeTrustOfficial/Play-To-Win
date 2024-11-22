<?php

namespace App\PlayToWin\Modele\DataObject;

class Coaching extends Services {

    public function getControleur(): string {
        return "coaching";
    }

    private int $duree;

    /**
     * @param ?int $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param string $coach
     * @param string $codeJeu
     * @param int $duree
     */
    public function __construct(
        ?int $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        string $coach,
        string $codeJeu,
        int $duree
    ) {
        parent::__construct(
            $codeService,
            $nomService,
            $descriptionService,
            $prixService,
            $coach,
            $codeJeu
        );
        $this->duree = $duree;
    }

    public function getDuree(): int {
        return $this->duree;
    }

    public function setDuree(int $duree): void {
        $this->duree = $duree;
    }

    public function setAttributsEnfant(array $attribsEnfant): void {
        if (isset($attribsEnfant['duree'])) {
            $this->setDuree($attribsEnfant['duree']);
        }
    }

    public function getAttributsEnfants(): array {
        return ["duree"];
    }
}