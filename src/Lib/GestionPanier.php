<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;

class GestionPanier {

    public static function getPanier(): array {
        $session = Session::getInstance();
        return $session->lire('panier') ?? [];
    }

    public static function viderPanier() : void{
        $session = Session::getInstance();
        $session->supprimer('panier');
    }

    public static function ajouterAuPanier() : void {
        if (!isset($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Code du service manquant.");
            return;
        }

        $codeService = $_REQUEST['id'];
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
                    'id' => $service->getId(),
                    'nom' => $service->getNom(),
                    'prix' => $service->getPrixService(),
                    'quantite' => 1,
                    'typeService' => $service->getControleur()
                ];
                MessageFlash::ajouter("success", "Service ajouté au panier !");
            }

            $session->enregistrer('panier', $panier);
        } else {
            MessageFlash::ajouter("danger", "Service introuvable.");
        }
    }

    public static function modifierQuantite(): void {
        if (!isset($_REQUEST['id']) || !isset($_REQUEST['quantite'])) {
            MessageFlash::ajouter("danger", "Code du service ou quantité manquant.");
            return;
        }

        $codeService = $_REQUEST['id'];
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
        if (!isset($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Code du service manquant.");
            return;
        }

        $codeService = $_REQUEST['id'];
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

    public static function getTotalPrix(): float {
        $session = Session::getInstance();
        $panier = $session->lire('panier');
        $totalGlobal = 0;

        foreach ($panier as $produit) {
            $sousTotal = $produit['prix'] * $produit['quantite'];
            $totalGlobal += $sousTotal;
        }

        return $totalGlobal;
    }
}