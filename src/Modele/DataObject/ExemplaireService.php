<?php

namespace App\PlayToWin\Modele\DataObject;

abstract class ExemplaireService extends AbstractDataObject {

    private ?int $idExemplaire;
    private string $etatService;
    private string $sujet;
    private string $codeService;
    private string $idPanier;

    /**
     * @param int|null $idExemplaire
     * @param string $etatService
     * @param string $sujet
     * @param string $codeService
     * @param string $idPanier
     */
    public function __construct(?int $idExemplaire, string $etatService, string $sujet, string $codeService, string $idPanier)
    {
        $this->idExemplaire = $idExemplaire;
        $this->etatService = $etatService;
        $this->sujet = $sujet;
        $this->codeService = $codeService;
        $this->idPanier = $idPanier;
    }


    public function getIdExemplaire(): ?int {
        return $this->idExemplaire;
    }

    public function setIdExemplaire(?int $idExemplaire): void {
        $this->idExemplaire = $idExemplaire;
    }

    public function getEtatService(): string {
        return $this->etatService;
    }

    public function setEtatService(string $etatService): void {
        $this->etatService = $etatService;
    }

    public function getSujet(): string {
        return $this->sujet;
    }

    public function setSujet(string $sujet): void {
        $this->sujet = $sujet;
    }

    public function getCodeService(): string {
        return $this->codeService;
    }

    public function setCodeService(string $codeService): void {
        $this->codeService = $codeService;
    }

    public function getIdPanier(): string {
        return $this->idPanier;
    }

    public function setIdPanier(string $idPanier): void {
        $this->idPanier = $idPanier;
    }



}
