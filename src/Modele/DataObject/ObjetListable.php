<?php

namespace App\PlayToWin\Modele\DataObject;

abstract class ObjetListable extends AbstractDataObject{
    abstract public function getId();
    abstract public function getNom();

}