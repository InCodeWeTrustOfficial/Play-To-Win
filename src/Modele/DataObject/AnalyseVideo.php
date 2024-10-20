<?php

namespace App\Covoiturage\Modele\DataObject;

use Cassandra\Date;

class AnalyseVideo extends Services {

    private Date $Rendu;

    /**
     * @param string $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param int $prix
     * @param string $coach
     * @param string $nomJeu
     * @param Date $Rendu
     */
    public function __construct(
        string $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        int $prix,
        string $coach,
        string $nomJeu,
        Date $Rendu
    ) {
        parent::__construct($codeService, $nomService, $descriptionService, $prixService, $prix, $coach, $nomJeu);
        $this->Rendu = $Rendu;
    }

    public function getRendu(): Date {
        return $this->Rendu;
    }

    public function setRendu(Date $Rendu): void {
        $this->Rendu = $Rendu;
    }


}