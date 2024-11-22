<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\CommandeRepository;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\Single\ExemplaireServiceRepository;
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
        $panier = Session::getInstance()->lire('panier');
        self::afficherVue('vueGenerale.php', [
            "titre" => "Liste des services dans passer commande",
            "cheminCorpsVue" => "service/formulairePanier.php",
            'panier' => $panier,
            'controleur' => self::$controleur
        ]);
    }

    public static function passerCommande(): void {
        try {
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

            $session = Session::getInstance();
            $panier = $session->lire('panier');

            $sujets = $_GET['sujet'] ?? [];
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

            $session->supprimer('panier');
            MessageFlash::ajouter("success", "Commande passée avec succès.");
            self::redirectionVersURL("afficherListe", "coach");
        } catch (\Exception $e) {
            MessageFlash::ajouter("danger", "Erreur lors de la commande : " . htmlspecialchars($e->getMessage()));
            self::redirectionVersURL("afficherPanier", self::$controleur);
        }
    }

    /**
     * Construit un objet service en fonction du formulaire rempli par l'utilisateur.
     * @param array $tableauDonneesFormulaire
     * @return Services|null
     */
    private static function construireDepuisFormulaire(): Commande {
        return (new CommandeRepository())->construireDepuisTableauSQL();
    }

}