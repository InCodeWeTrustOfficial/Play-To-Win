<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Coaching;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;

class ControleurCoaching extends ControleurService {

    protected static string $controleur = "coaching";

    public function supprimer() : void {
        parent::supprimerUtils((new CoachingRepository()));
    }

    public function mettreAJour(): void {
        parent::mettreAJourUtil((new CoachingRepository()));
    }

    public static function afficherFormulaireMiseAJour() {
        parent::afficherFormulaireMiseAJourUtil(new CoachingRepository());
    }

    /**
     * Permet a l'utilisateur de proposer un services (coaching / analyse vidéo)
     * @return void
     */
    public function creerDepuisFormulaire(): void {
        parent::creerDepuisFormulaireUtil(new CoachingRepository());
    }

    /**
     * Construit un objet service en fonction du formulaire rempli par l'utilisateur.
     * @param array $tableauDonneesFormulaire
     * @return Services|null
     */
    public function construireDepuisFormulaire(array $tableauDonneesFormulaire): Services {

        $nomService = $tableauDonneesFormulaire['nom_services'];
        $descriptionService = $tableauDonneesFormulaire['description'];
        $codeJeu = $tableauDonneesFormulaire['jeu'];
        $prix = $tableauDonneesFormulaire['prix'];
        $coach = ConnexionUtilisateur::getIdUtilisateurConnecte();
        $duree = $tableauDonneesFormulaire['duree'];

        return new Coaching (
            null,
            $nomService,
            $descriptionService,
            $prix,
            $coach,
            $codeJeu,
            $duree
        );
    }

    public static function getControleur(): string {
        return self::$controleur;
    }

}