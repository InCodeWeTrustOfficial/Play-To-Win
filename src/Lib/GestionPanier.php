<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;

class GestionPanier {

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