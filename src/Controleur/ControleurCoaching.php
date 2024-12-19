<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Coaching;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class ControleurCoaching extends ControleurService {

    protected static string $controleur = "coaching";

    public static function supprimer() : void {
        parent::supprimerUtils((new CoachingRepository()));
    }

    public static function mettreAJour(): void {
        parent::mettreAJourUtil((new CoachingRepository()));
    }

    public static function afficherFormulaireMiseAJour() {
        parent::afficherFormulaireMiseAJourUtil(new CoachingRepository());
    }

    public static function afficherDetail() {
        parent::afficherDetailUtil((new CoachingRepository()));
    }

    public static function afficherSelfListe() {
        parent::afficherSelfListeUtil((new CoachingRepository()));
    }

    public static function creerDepuisFormulaire(): void {
        parent::creerDepuisFormulaireUtil(new CoachingRepository());
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Service {
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
            (new CoachingRepository())->recupererParClePrimaire($coach),
            (new JeuRepository())->recupererParClePrimaire($codeJeu),
            $duree
        );
    }

    public static function getControleur(): string {
        return self::$controleur;
    }

}