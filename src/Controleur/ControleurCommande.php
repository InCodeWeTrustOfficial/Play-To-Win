<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Commande;
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
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des services dans passer commande", "cheminCorpsVue" => "service/formulairePanier.php", 'panier' => $panier, 'controleur' => self::$controleur]);
    }

    public static function passerCommande(): void {
        try {
            $commande = new Commande(
                null,
                new DateTime,
                ConnexionUtilisateur::getIdUtilisateurConnecte()
            );

            $commandeRepository = new CommandeRepository();
            $commandeRepository->ajouter($commande);

            MessageFlash::ajouter("success", "Commande passée avec succès.");
            self::redirectionVersURL("afficherListe", self::$controleur);

        } catch (\Exception $e) {
            MessageFlash::ajouter("danger", $e->getMessage());
            self::redirectionVersURL("afficherPanier", self::$controleur);
        }
    }
}