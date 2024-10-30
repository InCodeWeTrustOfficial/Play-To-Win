<?php

namespace App\PlayToWin\Modele\DataObject;

class ModeDeJeu extends AbstractDataObject {
    private string $nomMode;

    public function __construct(string $nomMode) {
        $this->nomMode = $nomMode;
    }
    public function getNomMode(): string {
        return $this->nomMode;
    }
}