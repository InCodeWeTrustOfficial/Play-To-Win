<?php

namespace App\PlayToWin\Modele\DataObject;

class Langue extends AbstractDataObject {
    private string $code_alpha;
    private string $nomLangue;
    private static string $drapeauxPath = "ressources/img/drapeaux/";

    public function __construct(string $code_alpha, string $nomLangue){
        $this->code_alpha = $code_alpha;
        $this->nomLangue = $nomLangue;
    }

    public function getCodeAlpha(): string{
        return $this->code_alpha;
    }

    public function getNom(): string{
        return $this->nomLangue;
    }
    public function getDrapeauPath(): string{
        return self::$drapeauxPath.strtolower($this->code_alpha).".png";
    }
}