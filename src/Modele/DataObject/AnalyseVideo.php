<?php

namespace App\PlayToWin\Modele\DataObject;

class AnalyseVideo extends Service {

    private int $nbJourRendu;

    public function __construct(
        ?int $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        string $coach,
        string $codeJeu,
        int $nbJourRendu
    ) {
        parent::__construct(
            $codeService,     // codeService
            $nomService,         // nomService
            $descriptionService, // descriptionService
            $prixService,        // prixService
            $coach,              // coach
            $codeJeu              // codeJeu
        );
        $this->nbJourRendu = $nbJourRendu;
    }

    public function getNbJourRendu(): int {
        return $this->nbJourRendu;
    }

    public function setNbJourRendu(int $nbJourRendu): void {
        $this->nbJourRendu = $nbJourRendu;
    }

    public function getControleur(): string {
        return "analysevideo";
    }

    public function setAttributsEnfant(array $attribsEnfant): void {
        $this->setNbJourRendu($attribsEnfant['nbJourRendu']);
    }

    public function getAttributsEnfants(): array {
        return ["nbJourRendu"];
    }
}