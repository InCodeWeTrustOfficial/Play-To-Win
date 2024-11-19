<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\GestionPanier;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;

abstract class ControleurService extends ControleurGenerique {

    protected static string $controleur = 'service';
    abstract static function getControleur(): string;
    abstract static function creerDepuisFormulaire(): void;

    public static function afficherListe() : void {
        if (isset($_REQUEST['id'])) {
            $coachId = $_REQUEST['id'];
            $services = array_merge(
                (new AnalyseVideoRepository())->recupererParCoach($coachId),
                (new CoachingRepository())->recupererParCoach($coachId)
            );
            self::afficherVue('vueGenerale.php', [
                "titre" => "Liste des services",
                "cheminCorpsVue" => "service/liste.php",
                'services' => $services,
                'id' => $coachId,
                'controleur' => self::$controleur
            ]);
        } else {
            MessageFlash::ajouter("danger", "Erreur, le coach n'existe pas !");
        }
    }

    public static function afficherListeAnalyse() : void {
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Erreur: ID du coach manquant ou vide!");
            self::redirectionVersURL("afficherListe", "coach");
            return;
        }

        $coachId = htmlspecialchars($_REQUEST['id']);
        $services = (new AnalyseVideoRepository())->recupererParCoach($coachId);

        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "service/liste.php",
            'services' => $services,
            'id' => $coachId,
            'controleur' => self::$controleur
        ]);
    }

    public static function afficherListeCoaching() : void {
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Erreur: ID du coach manquant ou vide!");
            self::redirectionVersURL("afficherListe", "coach");
            return;
        }

        $coachId = htmlspecialchars($_REQUEST['id']);
        $services = (new CoachingRepository())->recupererParCoach($coachId);

        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "service/liste.php",
            'services' => $services,
            'id' => $coachId,
            'controleur' => self::$controleur
        ]);
    }

    public static function afficherFormulaireMiseAJour() : void {
        if (!isset($_REQUEST['codeService'])) {
            MessageFlash::ajouter("danger", "Erreur, le service n'existe pas !");
            self::afficherErreur("Erreur, le service n'existe pas !");
        } else {
            $codeService = $_REQUEST['codeService'];
            self::afficherVue('vueGenerale.php', [
                "titre" => "Formulaire de MAJ",
                "cheminCorpsVue" => 'service/formulaireMiseAJour' . ucfirst(static::getControleur()) . '.php',
                'codeService' => $codeService,
                'controleur' => self::$controleur]);
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

    public static function afficherFormulaireProposerService() : void {
        self::afficherVue('vueGenerale.php', ["titre" => "Proposition services", "cheminCorpsVue" => 'service/formulaireCreation.php']);
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : $messageErreur");
        self::afficherVue('vueGenerale.php', ["titre" => "Problème avec le service", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur, 'controleur' => self::$controleur]);
    }

    public static function afficherPanier() : void {
        $panier = Session::getInstance()->lire('panier');
        self::afficherVue('vueGenerale.php',["titre" => "Panier", "cheminCorpsVue" => "service/panier.php", 'panier' => $panier, 'controleur'=>self::$controleur]);
    }

    public static function ajouterAuPanier() : void {
        GestionPanier::ajouterAuPanier();
        self::redirectionVersURL("afficherListe", 'coach');
    }

    public static function modifierQuantite(): void {
        GestionPanier::modifierQuantite();
        self::redirectionVersURL("afficherPanier", self::$controleur);
    }

    public static function supprimerProduit(): void {
        GestionPanier::supprimerProduit();
        self::redirectionVersURL("afficherPanier", self::$controleur);
    }

}
