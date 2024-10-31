<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\CommandeRepository;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\ExemplaireServiceRepository;

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
            $commandeRepository = new CommandeRepository();
            $commande = $commandeRepository->construireDepuisTableauSQL([]);

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare(
                "INSERT INTO p_Commandes (idCommande, dateAchatCommande, idUtilisateur) 
             VALUES (:idCommandeTag, :dateAchatCommandeTag, :idUtilisateurTag)"
            );

            $values = [
                'idCommandeTag' => $commande->getIdCommande(),
                'dateAchatCommandeTag' => $commande->getDateAchat()->format('Y-m-d H:i:s'),
                'idUtilisateurTag' => $commande->getIdUtilisateur()
            ];

            $pdoStatement->execute($values);
            $commandeRepository->ajouter($commande);
            $idCommande = ConnexionBaseDeDonnees::getPdo()->lastInsertId();

            echo $idCommande . "<br>";

            $session = Session::getInstance();
            $panier = $session->lire('panier');

            $sujets = $_GET['sujet'] ?? [];

            foreach ($panier as $codeService => $produit) {

                for ($i = 0; $i < $produit['quantite']; $i++) {
                    $sujet = $sujets[$codeService][$i] ?? '';

                    if (!empty($sujet)) {
                        echo "<br>codeService : " . $codeService . "<br>";
                        echo "sujet : " . $sujet . "<br>";
                        echo "idCommande : " . $idCommande . "<br>";

                        $donnees = [
                            'codeService' => $codeService,
                            'sujet' => $sujet,
                            'idCommande' => $idCommande
                        ];

                        $exemplaireService = ControleurExemplaireService::construireDepuisFormulaire($donnees);
                        (new ExemplaireServiceRepository())->ajouter($exemplaireService);

                    }
                }
            }

//            $session->supprimer('panier');
//            MessageFlash::ajouter("success", "Commande passée avec succès.");
//            self::redirectionVersURL("afficherListe", "coach");

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