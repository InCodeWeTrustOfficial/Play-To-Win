<?php


namespace App\Covoiturage\Modele\DataObject;

class AnalyseVidéo extends Services
{

    private double $tempsMaxRendu;

    /**
     * @param float $duree
     */
    public function __construct(
        float $tempsMaxRendu
    )
    {
        $this->tempsMaxRendu = $tempsMaxRendu;
    }

    public function getTempsMaxRendu(): float
    {
        return $this->tempsMaxRendu;
    }

    public function setTempsMaxRendu(float $tempsMaxRendu): void
    {
        $this->tempsMaxRendu = $tempsMaxRendu;
    }



}