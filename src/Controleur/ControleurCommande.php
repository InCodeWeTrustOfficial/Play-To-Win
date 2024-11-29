<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\GestionPanier;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\CommandeRepository;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\Single\ExemplaireServiceRepository;
use App\PlayToWin\Modele\Repository\Single\LangueRepository;
use DateTime;

class ControleurCommande extends ControleurGenerique {

    protected static string $controleur = 'commande';

    public static function getControleur(): string {
        return self::$controleur;
    }

    public static function afficherListe() : void {
        $commandes = (new CommandeRepository)->recupererParCleEtrangere(ConnexionUtilisateur::getIdUtilisateurConnecte());
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des commandes", "cheminCorpsVue" => "commande/liste.php", 'commandes' => $commandes, 'controleur' => self::$controleur]);
    }

    public static function afficherFormulairePanier() {
        $panier = GestionPanier::getPanier();
        $totalprix = GestionPanier::getTotalPrix();
        self::afficherFormulaire('vueGenerale.php', [
            "titre" => "Liste des services proposés dans la commande",
            "cheminCorpsVue" => "service/formulairePanier.php",
            'panier' => $panier,
            'totalprix' => $totalprix,
            'controleur' => self::$controleur
        ]);
    }

    public static function passerCommande(): void {
        if (self::existePasRequest(["sujet"], "Le coach n'existe pas.")) return;

        if (!ConnexionUtilisateur::estConnecte()) {
            MessageFlash::ajouter("warning", "Vous n'êtes pas connecté.");
            self::redirectionVersURL("afficherFormulaireConnexion", "utilisateur");

        } else {
            $commandeRepository = new CommandeRepository();
            $commande = $commandeRepository->construireDepuisTableauSQL([
                    null,
                    null,
                    ConnexionUtilisateur::getIdUtilisateurConnecte(),
                    0.0
                ]
            );

            $commandeRepository->ajouter($commande);
            $idCommande = ConnexionBaseDeDonnees::getPdo()->lastInsertId();

            $panier = GestionPanier::getPanier();

            $sujets = $_REQUEST['sujet'] ?? [];
            $prixTotal = 0.0;

            foreach ($panier as $codeService => $produit) {
                $prixTotal = $prixTotal + ($produit['prix'] * $produit['quantite']);
                for ($i = 0; $i < $produit['quantite']; $i++) {
                    $sujet = $sujets[$codeService][$i] ?? '';
                    if (!empty($sujet)) {
                        $donnees = [
                            'codeService' => $codeService,
                            'sujet' => $sujet,
                            'idCommande' => $idCommande
                        ];

                        $exemplaireService = ControleurExemplaireservice::construireDepuisFormulaire($donnees);
                        (new ExemplaireServiceRepository())->ajouter($exemplaireService);

                    }
                }
            }

            GestionPanier::viderPanier();
            MessageFlash::ajouter("success", "Commande passée avec succès.");
            self::redirectionVersURL("afficherListe", "coach");
        }
    }

    /**
     * Construit un objet service en fonction du formulaire rempli par l'utilisateur.
     * @param array $tableauDonneesFormulaire
     * @return Service|null
     */
    private static function construireDepuisFormulaire(): Commande {
        return (new CommandeRepository())->construireDepuisTableauSQL();
    }

}