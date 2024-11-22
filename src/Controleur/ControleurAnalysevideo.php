<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;

class ControleurAnalysevideo extends ControleurService {

    protected static string $controleur = "analysevideo";

    public static function supprimer() : void {
        parent::supprimerUtils((new AnalyseVideoRepository()));
    }

    public static function mettreAJour(): void {
        parent::mettreAJourUtil((new AnalyseVideoRepository()));
    }

    public function creerDepuisFormulaire(): void {
        parent::creerDepuisFormulaireUtil(new AnalyseVideoRepository());
    }

    public static function afficherFormulaireMiseAJour() {
        parent::afficherFormulaireMiseAJourUtil(new AnalyseVideoRepository());
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Service {
        $nomService = $tableauDonneesFormulaire['nom_services'];
        $descriptionService = $tableauDonneesFormulaire['description'];
        $codeJeu = $tableauDonneesFormulaire['jeu'];
        $prix = $tableauDonneesFormulaire['prix'];
        $coach = ConnexionUtilisateur::getIdUtilisateurConnecte();
        $nbJourRendu = $tableauDonneesFormulaire['nbJourRendu'];

        return new AnalyseVideo(
            null,
            $nomService,
            $descriptionService,
            $prix,
            $coach,
            $codeJeu,
            $nbJourRendu
        );
    }

    public static function getControleur(): string {
        return self::$controleur;
    }

}