<?php

namespace App\PlayToWin\Modele\DataObject;

use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

abstract class Service extends ObjetListable {

    private ?int $codeService;
    private string $nomService;
    private string $descriptionService;
    private float $prixService;
    private string $idCoach;
    private string $codeJeu;

    abstract public function getControleur(): ?string;
    abstract public function setAttributsEnfant(array $attribsEnfant);
    abstract public function getAttributsEnfants(): array;

    /**
     * @param int $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param string $idCoach
     * @param string $codeJeu
     */
    public function __construct(
        ?int $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        string $idCoach,
        string $codeJeu
    ) {
        $this->codeService = $codeService;
        $this->nomService = $nomService;
        $this->descriptionService = $descriptionService;
        $this->prixService = $prixService;
        $this->idCoach = $idCoach;
        $this->codeJeu = $codeJeu;
    }

    public function getId(): ?int {
        return $this->codeService;
    }

    public function setCodeService(int $codeService): void {
        $this->codeService = $codeService;
    }

    public function getNom(): string {
        return $this->nomService;
    }

    public function setNomService(string $nomService): void {
        $this->nomService = $nomService;
    }

    public function getDescriptionService(): string {
        return $this->descriptionService;
    }

    public function setDescriptionService(string $descriptionService): void {
        $this->descriptionService = $descriptionService;
    }

    public function getPrixService(): float {
        return $this->prixService;
    }

    public function setPrixService(float $prixService): void {
        $this->prixService = $prixService;
    }

    public function getCoach(): string {
        return $this->idCoach;
    }

    public function setCoach(string $coach): void {
        $this->idCoach = $coach;
    }

    public function getCodeJeu(): string {
        return $this->codeJeu;
    }

    public function setCodeJeu(string $codeJeu): void {
        $this->codeJeu = $codeJeu;
    }

    public function getNomJeu(): ?string {
        $jeu = (new JeuRepository())->recupererParClePrimaire($this->codeJeu);
        return $jeu ? $jeu->getNomJeu() : null;
    }
}
