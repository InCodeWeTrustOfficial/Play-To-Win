<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class ControleurAnalysevideo extends ControleurService {

    protected static string $controleur = "analysevideo";

    public static function supprimer() : void {
        parent::supprimerUtils((new AnalyseVideoRepository()));
    }

    public static function mettreAJour(): void {
        parent::mettreAJourUtil((new AnalyseVideoRepository()));
    }

    public static function creerDepuisFormulaire(): void {
        parent::creerDepuisFormulaireUtil(new AnalyseVideoRepository());
    }

    public static function afficherFormulaireMiseAJour() {
        parent::afficherFormulaireMiseAJourUtil(new AnalyseVideoRepository());
    }

    public static function afficherDetail() {
        parent::afficherDetailUtil((new AnalyseVideoRepository()));
    }

    public static function afficherSelfListe() {
        parent::afficherSelfListeUtil((new AnalyseVideoRepository()));
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
            (new AnalyseVideoRepository())->recupererParClePrimaire($coach),
            (new JeuRepository())->recupererParClePrimaire($codeJeu),
            $nbJourRendu
        );
    }

    public static function getControleur(): string {
        return self::$controleur;
    }
}