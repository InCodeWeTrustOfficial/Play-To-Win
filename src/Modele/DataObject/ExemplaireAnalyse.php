<?php

namespace App\PlayToWin\Modele\DataObject;

class ExemplaireAnalyse extends ExemplaireService {

    private int $nbJourRendu;

    public function __construct(
        ?int $idExemplaire,
        string $etatService,
        string $sujet,
        string $codeService,
        string $idCommande,
        int $quantite,
        int $nbJourRendu,
    ) {
        parent::__construct(
            $idExemplaire,
            $etatService,
            $sujet,
            $codeService,
            $idCommande,
            $quantite,
        );
        $this->nbJourRendu = $nbJourRendu;
    }


    public function getNbJourRendu(): int {
        return $this->nbJourRendu;
    }

    public function setNbJourRendu(int $nbJourRendu): void {
        $this->nbJourRendu = $nbJourRendu;
    }

    public function getTypeService(): string {
        return "exemplaireanalysevideo";
    }
}