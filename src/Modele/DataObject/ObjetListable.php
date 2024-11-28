<?php

namespace App\PlayToWin\Modele\DataObject;

interface ObjetListable {
    function getIdListable(): ?string;
    function getNom(): ?string;
    function getNomColonnes(): array;
    function getElementColonnes(): array;
}