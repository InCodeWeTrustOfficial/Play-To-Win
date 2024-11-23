<?php

namespace App\PlayToWin\Modele\DataObject;

interface ObjetListable {
    function getId(): ?int;
    function getNom(): ?string;
    function getNomColonnes(): array;
    function getElementColonnes(): array;
}