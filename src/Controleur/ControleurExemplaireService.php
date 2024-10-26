<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;

abstract class ControleurExemplaireService extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';
    abstract static function getControleur(): string;
    abstract static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireService;

    public static function afficherListe() : void {
        $services = array_merge((new ExemplaireAnalyseRepository())->recuperer(), (new CoachingRepository())->recuperer());
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des exemplaire services", "cheminCorpsVue" => "exemplaireservice/liste.php", 'services' => $services, 'controleur' => self::$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void {
        if (!isset($_REQUEST['codeService'])) {
            MessageFlash::ajouter("danger", "Erreur, le service n'existe pas !");
            self::afficherErreur("Erreur, le service n'existe pas !");
        } else {
            $codeService = $_REQUEST['codeService'];
            self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'service/formulaireMiseAJour' . ucfirst(static::getControleur()) . '.php', 'codeService' => $codeService, 'controleur' => self::$controleur]);
        }
    }

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

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : $messageErreur");
        self::afficherVue('vueGenerale.php', ["titre" => "Problème avec le service", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur, 'controleur' => self::$controleur]);
    }

    public static function passerCommande() {
        if (!isset($_REQUEST['codeService'])) {
            MessageFlash::ajouter("danger", "Code du service manquant.");
            self::redirectionVersURL("afficherPanier", self::$controleur);
            return;
        }

        $session = Session::getInstance();
        $panier = $session->lire('panier');
        $codeService = $_REQUEST['codeService'];

        if (isset($panier[$codeService])) {
            unset($panier[$codeService]);
            MessageFlash::ajouter("success", "Service supprimé du panier.");
        } else {
            MessageFlash::ajouter("danger", "Service introuvable dans le panier.");
        }

        $service = static::construireDepuisFormulaire($_REQUEST);

        (new ExemplaireAnalyseRepository())->ajouter($service);

        $session->detruire();
        self::redirectionVersURL("afficherListe", self::$controleur);
    }




}
