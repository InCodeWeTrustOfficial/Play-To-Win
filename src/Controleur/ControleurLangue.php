<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\LangueRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class ControleurLangue extends ControleurGenerique{
    public static string $controleur = "langue";

    public static function supprimerLangue():void{

        if (self::existePasRequest(["lang", "id"], "Infos manquantes.")) return;

        if (!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits de faire ceci !");
            self::redirectionVersURL();
        } else {
            /** @var Langue $lang */
            $lang = (new LangueRepository())->recupererParClePrimaire($_REQUEST["lang"]);
            if ($lang == null) {
                MessageFlash::ajouter("danger", "La langue n'existe pas.");
                self::redirectionVersURL();
            } else {
                /** @var Utilisateur $utilisateur */
                $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST["id"]);
                /**  @var Langue[] $languesParlees */
                $parlerRepo = new ParlerRepository();
                $languesParlees = $parlerRepo->recupererLangues($utilisateur->getId());
                if (count($languesParlees) <= 1) {
                    MessageFlash::ajouter("warning", "Vous devez parler au moins une langue !");
                } else {
                    $parlerRepo->supprimerTuple(array($_REQUEST["id"], $_REQUEST["lang"]));
                    MessageFlash::ajouter("success", "suppression de la langue " . htmlspecialchars($lang->getNom()));
                }
                self::redirectionVersURL("afficherDetail&id=" . $utilisateur->getId(), "utilisateur");
            }
        }

    }

    public static function afficherFormulaireAjout():void{

        if (self::existePasRequest(["id"], "Infos manquantes.")) return;

        if (!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits de faire ceci !");
            self::redirectionVersURL();
        } else {
            $langues = (new LangueRepository())->recuperer();
            $languesParlees = (new ParlerRepository())->recupererLangues($_REQUEST["id"]);
            $languesNonParlees = array();
            if ($languesParlees == null) {
                $languesNonParlees = $langues;
            } else {
                /** @var Langue $l */
                /** @var Langue $languesParlees */
                foreach ($langues as $l) {
                    if (!in_array($l, $languesParlees)) {
                        $languesNonParlees[] = $l;
                    }
                }
            }
            self::afficherVue("vueGenerale.php", ["titre" => "Ajout d'une langue", "cheminCorpsVue" => "langue/formulaireAjout.php", "idUser" => $_REQUEST["id"], "langues" => $languesNonParlees]);
        }

    }

    public static function ajouterLangue():void{

        if (self::existePasRequest(["id", "lang"], "Infos manquantes.")) return;

        if (!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))) {
            MessageFlash::ajouter("danger", "Vous n'avez pas les droits de faire ceci !");
            self::redirectionVersURL();
        } else {
            if ($_REQUEST['lang'] == "rien") {
                MessageFlash::ajouter("info", "Sélectionnez une langue !");
                self::redirectionVersURL("afficherFormulaireAjout&id=" . $_REQUEST["id"], self::$controleur);
            } else {
                /** @var Langue $lang */
                $lang = (new LangueRepository())->recupererParClePrimaire($_REQUEST["lang"]);
                if ($lang == null) {
                    MessageFlash::ajouter("danger", "La langue n'existe pas.");
                    self::redirectionVersURL();
                } else {
                    $parlerRepo = new ParlerRepository();
                    if ($parlerRepo->existeTuple(array($_REQUEST['id'], $_REQUEST['lang']))) {
                        MessageFlash::ajouter("warning", "Vous parlez déjà cette langue. Si ce n'est pas le cas contactez un Administrateur.");
                        self::redirectionVersURL("afficherDetail&id=" . $_REQUEST['id'], "utilisateur");
                    } else {
                        $parlerRepo->ajouterTuple(array($_REQUEST['id'], $_REQUEST['lang']));
                        MessageFlash::ajouter("success", "Vous parlez désormais le " . $lang->getNom());
                        self::redirectionVersURL("afficherDetail&id=" . $_REQUEST['id'], "utilisateur");
                    }
                }
            }

        }
    }

}