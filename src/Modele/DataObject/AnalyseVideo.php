<?php

namespace App\Covoiturage\Modele\DataObject;

class AnalyseVideo extends Services {
    private int $nbJourRendu;

    public function __construct(
        int $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        float $prix,
        int $coach,
        string $nomJeu,
        int $nbJourRendu
    ) {
        parent::__construct($codeService, $nomService, $descriptionService, $prixService, $prix, $coach, $nomJeu);
        $this->nbJourRendu = $nbJourRendu;
    }

    public function getNbJourRendu(): int {
        return $this->nbJourRendu;
    }

    public function setNbJourRendu(int $nbJourRendu): void {
        $this->nbJourRendu = $nbJourRendu;
    }
}
