<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\CommandeRepository;
use App\PlayToWin\Modele\Repository\Single\ExemplaireServiceRepository;

class ControleurExemplaireservice extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';

    public static function afficherListe(): void {
        if (isset($_REQUEST['idcommande'])) {
            $idCommande = $_REQUEST['idcommande'];
            $exemplaireservices = (new ExemplaireServiceRepository)->recupererParCommande($idCommande);

            self::afficherVue('vueGenerale.php', [
                "titre" => "Liste des exemplaire services de la commande",
                "cheminCorpsVue" => "exemplaireservice/liste.php",
                'exemplaireservices' => $exemplaireservices,
                'controleur' => self::$controleur
            ]);

        } else {
            MessageFlash::ajouter("danger", "Erreur, le coach n'existe pas !");
            self::redirectionVersURL();
        }
    }
    public static function creerDepuisFormulaire(): void {
        $exemplaireService = self::construireDepuisFormulaire($_REQUEST);
        (new ExemplaireServiceRepository())->ajouter($exemplaireService);
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireService {
        $codeService = $tableauDonneesFormulaire['codeService'] ?? null;
        $sujet = $tableauDonneesFormulaire['sujet'] ?? '';
        $idCommande = $tableauDonneesFormulaire['idCommande'] ?? null;

        $commande = (new CommandeRepository())->recupererParClePrimaire($idCommande);

        $service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);
        if ($service === null) {
            $service = (new CoachingRepository())->recupererParClePrimaire($codeService);
        }

        return new ExemplaireService(
            null,           // ID généré automatiquement
            'achetee',      // état initial
            $sujet,         // Sujet
            $service,       // Service object instead of just the code
            $commande     // ID de la commande
        );
    }


}