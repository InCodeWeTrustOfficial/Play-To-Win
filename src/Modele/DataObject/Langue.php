<?php

namespace App\Covoiturage\Modele\DataObject;

class Langue extends AbstractDataObject
{
    private string $code_alpha;
    private string $nomLangue;
    private string $drapeau;

    public function __construct(string $code_alpha, string $nomLangue, string $drapeau){
        $this->code_alpha = $code_alpha;
        $this->nomLangue = $nomLangue;
        $this->drapeau = $drapeau;
    }

    public function getCodeAlpha(): string{
        return $this->code_alpha;
    }

    public function getNom(): string{
        return $this->nomLangue;
    }
    public function getDrapeau(): string{
        return $this->drapeau;
    }
}