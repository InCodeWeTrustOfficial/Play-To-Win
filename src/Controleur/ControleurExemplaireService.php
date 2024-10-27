<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;

abstract class ControleurExemplaireService extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';
    abstract static function getControleur(): string;
    abstract static function creerDepuisFormulaire(array $tableauDonneesFormulaire): void;

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

    public static function valdierCommande() {
        $panier = Session::getInstance()->lire('panier');
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des services dans passer commande", "cheminCorpsVue" => "service/dernierFormulaire.php", 'panier' => $panier, 'controleur' => self::$controleur]);
        static::creerDepuisFormulaire($_REQUEST);
    }


}
