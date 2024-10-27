<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireAnalyse;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;

class ControleurExemplaireAnalyse extends ControleurExemplaireService {

    protected static string $controleur = 'exemplaireanalyse';

    public static function afficherDetail() : void {

    }

    public static function creerDepuisFormulaire(array $tableauDonneesFormulaire): void {

        $session = Session::getInstance();
        $panier = $session->lire('panier');

        $codeService = $_REQUEST['codeService'] ?? null;
        $quantite = isset($_REQUEST['quantite']) ? (int)$_REQUEST['quantite'] : 1;

        if (!$codeService) {
            MessageFlash::ajouter("danger", "Code service manquant.");
            return;
        }

        for ($i = 0; $i < $quantite; $i++) {
            $service = self::construireDepuisFormulaire($_REQUEST);

            (new ExemplaireAnalyseRepository())->ajouter($service);
        }

        unset($panier[$codeService]);
        $session->enregistrer('panier', $panier);
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireAnalyse {
        $codeService = $tableauDonneesFormulaire['codeService'];
        $quantite = $tableauDonneesFormulaire['quantite'];

        $service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);

        return new ExemplaireAnalyse(
            null,                              // ID généré automatiquement
            'en cours',                        // Exemple d'état initial
            $service->getNomService(),         // Sujet ou nom du service
            $codeService,                      // Code du service d'origine
            $tableauDonneesFormulaire['idCommande'], // ID de la commande
            $quantite,                         // Quantité commandée
            $service->getNbJourRendu()         // Délai de rendu
        );
    }

    static function getControleur(): string {
        return self::$controleur;
    }
}
