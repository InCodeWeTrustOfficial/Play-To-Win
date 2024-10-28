<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\ExemplaireServiceRepository;

class ControleurExemplaireService extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';

    public static function afficherListe() : void {

    }

    public static function afficherFormulaireMiseAJour() : void {

    }

    public static function afficherDetail() : void {

    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : $messageErreur");
        self::afficherVue('vueGenerale.php', ["titre" => "Problème avec le service", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur, 'controleur' => self::$controleur]);
    }

    public static function creerDepuisFormulaire(): void {
        try {

            $exemplaireService = self::construireDepuisFormulaire($_REQUEST);

            (new ExemplaireServiceRepository())->ajouter($exemplaireService);
            echo "Ici";

        } catch (\Exception $e) {
            self::afficherErreur($e->getMessage());
        }
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireService {
        $codeService = $tableauDonneesFormulaire['codeService'];
        $sujet  = $tableauDonneesFormulaire['sujet'];

        return new ExemplaireService (
            null,                            // ID généré automatiquement
            'achetee',                        // état initial
            $sujet,                                     // sujet
            $codeService,                               // Code du service
            $tableauDonneesFormulaire['idCommande'],    // ID de la commande
        );
    }

}