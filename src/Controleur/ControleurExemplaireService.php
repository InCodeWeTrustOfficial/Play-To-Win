<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;

abstract class ControleurExemplaireService extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';
    abstract static function getControleur(): string;
    abstract static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireService;

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

    public static function creerDepuisCookie(): void {
        try {

            $service = static::construireDepuisFormulaire($_REQUEST);

            (new ExemplaireAnalyseRepository())->ajouter($service);


        } catch (\Exception $e) {
            self::afficherErreur("Une erreur est survenue lors de la création du service : " . $e->getMessage());
        }
    }


}
