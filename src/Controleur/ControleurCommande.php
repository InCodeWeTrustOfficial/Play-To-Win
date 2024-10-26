<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;
use App\PlayToWin\Modele\Repository\CommandeRepository;

class ControleurCommande extends ControleurGenerique {

    protected static string $controleur = 'commande';

    public static function getControleur(): string {
        return self::$controleur;
    }

    public static function passerCommande(): void {
        try {
            $session = Session::getInstance();
            $panier = $session->lire('panier');
            $codeService = $_REQUEST['codeService'];
            $quantite = (int)$_REQUEST['quantite'];

            $commande = new Commande(
                null,
                date('Y-m-d H:i:s'),
                ConnexionUtilisateur::getIdUtilisateurConnecte()
            );

            $commandeRepository = new CommandeRepository();
            $idCommande = $commandeRepository->ajouter($commande);

            $exemplaireRepository = new ExemplaireAnalyseRepository();

            for ($i = 0; $i < $quantite; $i++) {
                $exemplaire = ControleurExemplaireAnalyse::construireDepuisFormulaire([
                    'codeService' => $codeService,
                    'idCommande' => $idCommande,
                    'quantite' => 1
                ]);

                $exemplaireRepository->ajouter($exemplaire);
            }

            unset($panier[$codeService]);
            $session->detruire();

            MessageFlash::ajouter("success", "Commande passée avec succès.");
            self::redirectionVersURL("afficherListe", self::$controleur);

        } catch (\Exception $e) {
            MessageFlash::ajouter("danger", $e->getMessage());
            self::redirectionVersURL("afficherPanier", self::$controleur);
        }
    }
}