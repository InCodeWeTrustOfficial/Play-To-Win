<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Controleur\ControleurExemplaireService;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;

class GestionPanier {

    public static function AjouterExemplaire(string $idUtilisateur): void {
        $session = Session::getInstance();
        $panier = $session->lire('panier');

        $codeService = $_REQUEST['codeService'] ?? null;
        $quantite = isset($_REQUEST['quantite']) ? (int)$_REQUEST['quantite'] : 1;

        if (!$codeService) {
            MessageFlash::ajouter("danger", "Code service manquant.");
            return;
        }

        $exemplaireRepository = new ExemplaireAnalyseRepository();

        for ($i = 0; $i < $quantite; $i++) {
            $exemplaire = ControleurExemplaireService::construireDepuisFormulaire([
                'codeService' => $codeService,
                'idCommande' => $idCommande,
                'quantite' => 1
            ]);

            $exemplaireRepository->ajouter($exemplaire);
        }

        // Removing the service from the session basket and clearing session if necessary
        unset($panier[$codeService]);
        $session->enregistrer('panier', $panier);
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
    }
}