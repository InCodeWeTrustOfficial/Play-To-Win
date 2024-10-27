<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireAnalyse;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;

class ControleurExemplaireAnalyse extends ControleurExemplaireService {

    protected static string $controleur = 'exemplaireanalyse';

    public static function afficherDetail() : void {

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
