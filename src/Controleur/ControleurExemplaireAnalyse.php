<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireAnalyse;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;

class ControleurExemplaireAnalyse extends ControleurExemplaireService {

    protected static string $controleur = 'exsanalyse';

    public static function afficherDetail() : void {
        if (!isset($_REQUEST['codeService'])) {
            MessageFlash::ajouter("danger", "Code service manquant.");
            self::afficherErreur("Code service manquant.");
        } else {
            $codeService = $_REQUEST['codeService'];
            $service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);

            if ($service == NULL) {
                $service = (new CoachingRepository())->recupererParClePrimaire($codeService);
            }

            if ($service != NULL) {
                self::afficherVue('vueGenerale.php', ["titre" => "Détail du service", "cheminCorpsVue" => "service/detail" . ucfirst($service->getTypeService()) . ".php", 'service' => $service, 'controleur' => self::$controleur]);
            } else {
                MessageFlash::ajouter("danger", "Service introuvable : $codeService.");
                self::afficherErreur($codeService);
            }
        }
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
