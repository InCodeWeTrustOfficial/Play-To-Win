<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\ExemplaireService;
use App\PlayToWin\Modele\Repository\Single\ExemplaireServiceRepository;

class ControleurExemplaireservice extends ControleurGenerique {

    protected static string $controleur = 'exemplaireservice';

    public static function afficherListe(): void {
        if (isset($_REQUEST['idcommande'])) {
            $idCommande = $_REQUEST['idcommande'];
            $exemplaireservices = (new ExemplaireServiceRepository)->recupererParCommande($idCommande);
            self::afficherVue('vueGenerale.php', [
                "titre" => "Liste des exemplaire services de la commande",
                "cheminCorpsVue" => "exemplaireservice/liste.php",
                'exemplaireservices' => $exemplaireservices,
                'controleur' => self::$controleur
            ]);
        } else {
            MessageFlash::ajouter("danger", "Erreur, le coach n'existe pas !");
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : ".htmlspecialchars($messageErreur));
        self::afficherVue('vueGenerale.php', ["titre" => "Problème avec le service", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur, 'controleur' => self::$controleur]);
    }

    public static function creerDepuisFormulaire(): void {
        try {
            $exemplaireService = self::construireDepuisFormulaire($_REQUEST);
            (new ExemplaireServiceRepository())->ajouter($exemplaireService);

        } catch (\Exception $e) {
            self::afficherErreur($e->getMessage());
        }
    }

    public static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ExemplaireService {
        $codeService = $tableauDonneesFormulaire['codeService'] ?? null;
        $sujet = $tableauDonneesFormulaire['sujet'] ?? '';
        $idCommande = $tableauDonneesFormulaire['idCommande'] ?? null;

        echo $idCommande;
        return new ExemplaireService(
            null,                     // ID généré automatiquement
            'achetee',                // état initial
            $sujet,                   // Sujet en tant que chaîne de caractères
            $codeService,             // Code du service
            $idCommande               // ID de la commande
        );
    }


}