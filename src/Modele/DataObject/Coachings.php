<?php

namespace App\Covoiturage\Modele\DataObject;

class Coachings extends Services {

    private double $duree;

    /**
     * @param float $duree
     */
    public function __construct(
        float $duree
    ){
        $this->duree = $duree;
    }

    public function getDuree(): float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): void
    {
        $this->duree = $duree;
    }


}