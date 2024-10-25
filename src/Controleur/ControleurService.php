<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;

abstract class ControleurService extends ControleurGenerique {

    protected static string $controleur = 'service';
    abstract static function getControleur(): string ;

    public static function afficherListe() : void {
        $services = array_merge((new AnalyseVideoRepository())->recuperer(), (new CoachingRepository())->recuperer());
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des services", "cheminCorpsVue" => "service/liste.php", 'services' => $services, 'controleur' => self::$controleur]);
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
        self::afficherVue('vueGenerale.php',["titre" => "Panier", "cheminCorpsVue" => "service/panier.php", 'controleur'=>self::$controleur]);
    }

    public static function ajouterAuPanier() : void {
        if (!isset($_REQUEST['codeService'])) {
            MessageFlash::ajouter("danger", "Code du service manquant.");
            self::redirectionVersURL("afficherListe", self::$controleur);
            return;
        }

        $codeService = $_REQUEST['codeService'];
        $service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);

        if ($service == null) {
            $service = (new CoachingRepository())->recupererParClePrimaire($codeService);
        }

        if ($service != null) {
            $session = Session::getInstance();
            $panier = $session->lire('panier');

            if (isset($panier[$codeService])) {
                $panier[$codeService]['quantite']++;
                MessageFlash::ajouter("info", "La quantité du service a été augmentée.");
            } else {
                $panier[$codeService] = [
                    'id' => $service->getCodeService(),
                    'nom' => $service->getNomService(),
                    'prix' => $service->getPrixService(),
                    'quantite' => 1
                ];
                MessageFlash::ajouter("success", "Service ajouté au panier !");
            }

            $session->enregistrer('panier', $panier);
        } else {
            MessageFlash::ajouter("danger", "Service introuvable.");
        }

        self::redirectionVersURL("afficherListe", self::$controleur);
    }

    public static function modifierQuantite(): void {
        if (!isset($_REQUEST['codeService']) || !isset($_REQUEST['quantite'])) {
            MessageFlash::ajouter("danger", "Code du service ou quantité manquant.");
            self::redirectionVersURL("afficherPanier", self::$controleur);
            return;
        }

        $codeService = $_REQUEST['codeService'];
        $quantite = (int)$_REQUEST['quantite'];

        $session = Session::getInstance();
        $panier = $session->lire('panier');

        if (isset($panier[$codeService])) {
            if ($quantite <= 0) {
                unset($panier[$codeService]);
                MessageFlash::ajouter("info", "Service supprimé du panier.");
            } else {
                $panier[$codeService]['quantite'] = $quantite;
                MessageFlash::ajouter("success", "Quantité mise à jour.");
            }
        } else {
            MessageFlash::ajouter("danger", "Service introuvable dans le panier.");
        }

        $session->enregistrer('panier', $panier);
        self::redirectionVersURL("afficherPanier", self::$controleur);
    }

    public static function supprimerProduit(): void {
        if (!isset($_REQUEST['codeService'])) {
            MessageFlash::ajouter("danger", "Code du service manquant.");
            self::redirectionVersURL("afficherPanier", self::$controleur);
            return;
        }

        $codeService = $_REQUEST['codeService'];
        $session = Session::getInstance();
        $panier = $session->lire('panier');

        if (isset($panier[$codeService])) {
            unset($panier[$codeService]);
            MessageFlash::ajouter("success", "Service supprimé du panier.");
        } else {
            MessageFlash::ajouter("danger", "Service introuvable dans le panier.");
        }

        $session->enregistrer('panier', $panier);
        self::redirectionVersURL("afficherPanier", self::$controleur);
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



        $session->detruire();
        self::redirectionVersURL("afficherListe", self::$controleur);
    }
}
