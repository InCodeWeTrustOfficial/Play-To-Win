<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\ExemplaireAnalyseRepository;

abstract class ControleurExemplaireService extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';
    abstract static function getControleur(): string;
    abstract static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireService;

    public static function afficherListe() : void {

    }

    public static function afficherFormulaireMiseAJour() : void {

    }

    public static function afficherDetail() : void {

    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : $messageErreur");
        self::afficherVue('vueGenerale.php', ["titre" => "Problème avec le service", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur, 'controleur' => self::$controleur]);
    }

    public static function valdierCommande() {
        $panier = Session::getInstance()->lire('panier');
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des services dans passer commande", "cheminCorpsVue" => "service/dernierFormulaire.php", 'panier' => $panier, 'controleur' => self::$controleur]);
        creerDepuisCookie();
    }

    public static function AjouterExemplaire(array $tableauDonneesFormulaire): void {
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
            $exemplaire = ControleurExemplaireAnalyse::construireDepuisFormulaire([
                'codeService' => $codeService,
                'idCommande' => $idCommande,
                'quantite' => 1
            ]);

            $exemplaireRepository->ajouter($exemplaire);
        }

        unset($panier[$codeService]);
        $session->enregistrer('panier', $panier);
    }

    public static function creerDepuisCookie(): void {
        try {

            $service = static::construireDepuisFormulaire($_REQUEST);

            (new ExemplaireAnalyseRepository())->ajouter($service);


        } catch (\Exception $e) {
            self::afficherErreur("Une erreur est survenue lors de la création du service : " . $e->getMessage());
        }
    }


}
