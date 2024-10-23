<?php

namespace App\Covoiturage\Modele\DataObject;

class Classement extends AbstractDataObject
{
    private string $idClassement;
    private string $nomClassement;
    private string $divisionClassement;

    public function __construct(string $idClassement, string $nomClassement, string $divisionClassement){
        $this->idClassement = $idClassement;
        $this->nomClassement = $nomClassement;
        $this->divisionClassement = $divisionClassement;
    }

    public function getIdClassement(): string
    {
        return $this->idClassement;
    }

    public function getNomClassement(): string
    {
        return $this->nomClassement;
    }

    public function getDivisionClassement(): string
    {
        return $this->divisionClassement;
    }

}