<?php

namespace App\PlayToWin\Modele\DataObject;

use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

abstract class Service extends AbstractDataObject implements ObjetListable {

    private ?int $codeService;
    private string $nomService;
    private string $descriptionService;
    private float $prixService;
    private Coach $coach;
    private Jeu $jeu;

    abstract public function getControleur(): ?string;
    abstract public function setAttributsEnfant(array $attribsEnfant);
    abstract public function getAttributsEnfants(): array;

    /**
     * @param int $codeService
     * @param string $nomService
     * @param string $descriptionService
     * @param float $prixService
     * @param Coach $Coach
     * @param Jeu $Jeu
     */
    public function __construct(
        ?int $codeService,
        string $nomService,
        string $descriptionService,
        float $prixService,
        Coach $coach,
        Jeu $jeu
    ) {
        $this->codeService = $codeService;
        $this->nomService = $nomService;
        $this->descriptionService = $descriptionService;
        $this->prixService = $prixService;
        $this->coach = $coach;
        $this->jeu = $jeu;
    }

    public function getNomColonnes(): array {
        return ["Identifiant", "idcoach", "nom"];
    }

    public function getElementColonnes(): array{
        return [$this->getId(), $this->getIdCoach() ,$this->getNom()];
    }

    public function getId(): ?int {
        return $this->codeService;
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

    public function getIdCoach(): ?string {
        return $this->coach?->getId();
    }

    public function getCoach(): Coach {
        return $this->coach;
    }

    public function getJeu(): Jeu {
        return $this->jeu;
    }

    public function getCodeJeu(): string {
        return $this->jeu->getCodeJeu();
    }

    public function getNomJeu(): ?string {
        return $this->jeu->getNomJeu();
    }

//    public function setCodeJeu(string $codeJeu): void {
//        $this->jeu->getCodeJeu() = $codeJeu;
//    }
}
