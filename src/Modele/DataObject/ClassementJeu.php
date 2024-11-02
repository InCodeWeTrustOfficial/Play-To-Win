<?php

namespace App\PlayToWin\Modele\DataObject;

class ClassementJeu extends AbstractDataObject {
    private Jeu $jeu;
    private Classement $classement;
    private int $place;
    private int $eloMin;
    private int $eloMax;
    private int $cumulElo;

    private string $classPath;

    public function __construct(Classement $classement, Jeu $jeu, int $place, int $eloMin, int $eloMax, int $cumulElo) {
        $this->jeu = $jeu;
        $this->classement = $classement;
        $this->place = $place;
        $this->eloMin = $eloMin;
        $this->eloMax = $eloMax;
        $this->cumulElo = $cumulElo;

        $this->classPath = $this->genererPath();

    }

    public function getJeu(): Jeu
    {
        return $this->jeu;
    }
    public function getCodeJeu() : string {
        return $this->jeu->getCodeJeu();
    }

    public function getClassement(): Classement
    {
        return $this->classement;
    }

    public function getPlace(): int
    {
        return $this->place;
    }

    public function getEloMin(): int
    {
        return $this->eloMin;
    }

    public function getEloMax(): int
    {
        return $this->eloMax;
    }

    public function getCumulElo(): int
    {
        return $this->cumulElo;
    }

    public function getClassPath(): string
    {
        return $this->classPath;
    }

    private function genererPath(): string{
        $str = "ressources/img/classement/".$this->jeu->getCodeJeu()."/".$this->classement->getAcronyme();
        if($this->jeu->getCodeJeu() == 'rl' && $this->classement->getDivisionClassement() != 0){
            $str.=$this->classement->getDivisionClassement();
        }
        return $str.".png";
    }
}