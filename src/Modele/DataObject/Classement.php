<?php

namespace App\PlayToWin\Modele\DataObject;

class Classement extends AbstractDataObject
{
    private string $idClassement;
    private string $nomClassement;
    private int $divisionClassement;
    private string $acronyme;

    public function __construct(string $idClassement, string $nomClassement, int $divisionClassement, string $acronyme){
        $this->idClassement = $idClassement;
        $this->nomClassement = $nomClassement;
        $this->divisionClassement = $divisionClassement;
        $this->acronyme = $acronyme;
    }

    public function getIdClassement(): string
    {
        return $this->idClassement;
    }

    public function getNomClassement(): string
    {
        $div = "";
        if(!$this->divisionClassement == 0){
            $div .= $this->divisionClassement;
        }
        return $this->nomClassement.$div;
    }

    public function getDivisionClassement():int{
        return $this->divisionClassement;
    }

    public function getAcronyme(): string{
        return $this->acronyme;
    }

}