<?php

namespace App\Covoiturage\Modele\DataObject;

class AnalyseVideo extends Services {
    private int $nbJourRendu;

    public function __construct(
        string $nomService,
        string $descriptionService,
        float $prixService,
        string $coach,
        string $nomJeu,
        int $nbJourRendu
    ) {
        parent::__construct(
            null,
            $nomService,
            $descriptionService,
            $prixService,
            $prixService,
            $coach,
            $nomJeu
        );
        $this->nbJourRendu = $nbJourRendu;
    }

    public function getNbJourRendu(): int {
        return $this->nbJourRendu;
    }

    public function setNbJourRendu(int $nbJourRendu): void {
        $this->nbJourRendu = $nbJourRendu;
    }
}
