<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\CommandeRepository;
use DateTime;

class ControleurCommande extends ControleurGenerique {

    protected static string $controleur = 'commande';

    public static function getControleur(): string {
        return self::$controleur;
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
            $session = Session::getInstance();
            $panier = $session->lire('panier');



            $commandeRepository = new CommandeRepository();
            $idCommande = $commandeRepository->ajouter($commande);

            echo $idCommande;

            // Récupérer les sujets du formulaire
            $sujets = $_POST['sujets'] ?? [];

            // Créer les exemplaires de service pour chaque produit
            foreach ($panier as $codeService => $produit) {
                for ($i = 0; $i < $produit['quantite']; $i++) {
                    $sujet = $sujets[$codeService][$i] ?? '';

                    // Préparer les données pour l'exemplaire
                    $donnees = [
                        'codeService' => $codeService,
                        'sujet' => $sujet,
                        'idCommande' => $idCommande
                    ];

                    // Créer l'exemplaire via le contrôleur dédié
                    ControleurExemplaireService::creerDepuisFormulaire($donnees);
                }
            }

            // Vider le panier après succès
            $session->supprimer('panier');

//            MessageFlash::ajouter("success", "Commande passée avec succès.");
//            self::redirectionVersURL("afficherListe", self::$controleur);

        } catch (\Exception $e) {
            MessageFlash::ajouter("danger", "Erreur lors de la commande : " . $e->getMessage());
            self::redirectionVersURL("afficherPanier", self::$controleur);
        }
    }
}