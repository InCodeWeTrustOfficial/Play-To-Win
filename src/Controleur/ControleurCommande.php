<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\CommandeRepository;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
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
            $commande = $commandeRepository->construireDepuisTableauSQL([]);

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare("INSERT INTO p_Commandes (idCommande, dateAchatCommande, idUtilisateur) VALUES (:idCommandeTag, :dateAchatCommandeTag, :idUtilisateurTag)");

            $values = [
                'idCommandeTag' => $commande->getIdCommande(),
                'dateAchatCommandeTag' => $commande->getDateAchat()->format('Y-m-d H:i:s'),
                'idUtilisateurTag' => $commande->getIdUtilisateur()
            ];

            $pdoStatement->execute($values);
            $commandeRepository->ajouter($commande);

            $idCommande = ConnexionBaseDeDonnees::getPdo()->lastInsertId();

            $sujets = $_GET['sujet'];
            foreach ($panier as $id => $produit) {
                for ($i = 0; $i < $produit['quantite']; $i++) {
                    $sujet = $sujets[$id][$i] ?? '';

                    if (!empty($sujet)) { // Vérifiez que le sujet est bien défini
                        $donnees = [
                            'codeService' => $id,
                            'sujet' => $sujet,
                            'idCommande' => $idCommande
                        ];

                        ControleurExemplaireService::creerDepuisFormulaire($donnees);
                    }
                }
            }

            $session->supprimer('panier');
//            MessageFlash::ajouter("success", "Commande passée avec succès.");
//            self::redirectionVersURL("afficherListe", self::$controleur);

        } catch (\Exception $e) {
            MessageFlash::ajouter("danger", "Erreur lors de la commande : " . $e->getMessage());
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