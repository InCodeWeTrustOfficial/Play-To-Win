<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Single\ClassementRepository;
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Classement;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\ModeDeJeu;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\ModeDeJeuRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class ControleurJouer extends ControleurGenerique {

    public static string $controleur = "jouer";

    public static function supprimerJouer(): void{
        if(!isset($_REQUEST["jeu"]) || !isset($_REQUEST["id"]) || !isset($_REQUEST["mode"])){
            MessageFlash::ajouter("danger","Infos manquantes.");
            self::redirectionVersURL();
        } else{
            if(!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))){
                MessageFlash::ajouter("danger","Vous n'avez pas les droits de faire ceci !");
                self::redirectionVersURL();
            } else{
                /** @var Jeu $jeu */
                $jeu = (new JeuRepository())->recupererParClePrimaire($_REQUEST["jeu"]);
                /** @var ModeDeJeu $mode */
                $mode = (new ModeDeJeuRepository())->recupererParClePrimaire($_REQUEST["mode"]);
                if($jeu == null){
                    MessageFlash::ajouter("danger","Le jeu n'existe pas.");
                    self::redirectionVersURL();
                } else if($mode == null){
                    MessageFlash::ajouter("danger","Le mode de jeu n'existe pas.");
                    self::redirectionVersURL();
                } else {

                    /** @var Utilisateur $utilisateur */
                    $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST["id"]);
                    /**  @var array $jeuxJoues */
                    $jouerRepo = new JouerRepository();
                    $jeuxJoues = $jouerRepo->recupererModeJeuClassement($_REQUEST["id"]);
                    if (count($jeuxJoues) <= 1) {
                        MessageFlash::ajouter("warning", "Vous devez jouer au minimum à un jeu !");
                    } else {
                        $jouerRepo->supprimerTuple(array($_REQUEST['jeu'],$_REQUEST["id"], $_REQUEST["mode"]));
                        MessageFlash::ajouter("success","suppression du jeu ".htmlspecialchars($jeu->getNomJeu())." dans le mode ".htmlspecialchars($mode->getNomMode()));
                    }
                    self::redirectionVersURL("afficherDetail&id=" . $utilisateur->getId(), "utilisateur");
                }
            }
        }
    }

    public static function afficherFormulaireJouer():void{
        if(!isset($_REQUEST['id'])){
            MessageFlash::ajouter("danger","Infos manquantes.");
            self::redirectionVersURL();
        } else{
            if(!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))){
                MessageFlash::ajouter("danger","Vous n'avez pas les droits de faire ceci !");
                self::redirectionVersURL();
            } else{

                $jeux = (new JeuRepository())->recuperer();
                $modes = (new ModeDeJeuRepository())->recuperer();
                $classements = (new ClassementRepository())->recuperer();

                $jouerJoues = (new JouerRepository())->recupererModeJeuClassement($_REQUEST["id"]);

                $jeuxNonJoues = array();
                $modesNonJoues = array();
                $classementsNonJoues = array();

                if($jouerJoues == null){
                    $jeuxNonJoues = $jeux;
                    $modesNonJoues = $modes;
                    $classementsNonJoues = $classements;

                } else{
                    foreach ($jeux as $j) {
                        if (!in_array($j, $jouerJoues[0])) {
                            $jeuxNonJoues[] = $j;
                        }
                    }
                    foreach ($modes as $m) {
                        if (!in_array($m, $jouerJoues[0])) {
                            $modesNonJoues[] = $m;
                        }
                    }
                    foreach ($classements as $c) {
                        if (!in_array($c, $jouerJoues[0])) {
                            $classementsNonJoues[] = $c;
                        }
                    }
                }
                self::afficherVue("vueGenerale.php",["titre" => "Ajout d'un jeu","cheminCorpsVue" => "jouer/formulaireJouer.php", "idUser" => $_REQUEST["id"], "jeux" => $jeuxNonJoues, "modes" => $modesNonJoues, "classements" => $classementsNonJoues]);
            }
        }
    }

    public static function ajouterJouer():void{
        if(!isset($_REQUEST["jeu"]) || !isset($_REQUEST["id"]) || !isset($_REQUEST["mode"]) || !isset($_REQUEST['class'])){
            MessageFlash::ajouter("danger","Infos manquantes.");
            self::redirectionVersURL();
        } else{
            if(!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))){
                MessageFlash::ajouter("danger","Vous n'avez pas les droits de faire ceci !");
                self::redirectionVersURL();
            } else{
                if($_REQUEST['jeu'] == "rien"){
                    MessageFlash::ajouter("info","Sélectionnez un jeu !");
                    self::redirectionVersURL("afficherFormulaireJouer&id=".$_REQUEST["id"], self::$controleur);
                } else if($_REQUEST['mode'] == "rien"){
                    MessageFlash::ajouter("info","Sélectionnez un mode !");
                    self::redirectionVersURL("afficherFormulaireJouer&id=".$_REQUEST["id"], self::$controleur);
                } else if($_REQUEST['class'] == "rien"){
                    MessageFlash::ajouter("info","Sélectionnez un classement !");
                    self::redirectionVersURL("afficherFormulaireJouer&id=".$_REQUEST["id"], self::$controleur);
                } else {
                    /** @var Jeu $jeu */
                    $jeu = (new JeuRepository())->recupererParClePrimaire($_REQUEST["jeu"]);
                    /** @var ModeDeJeu $mode */
                    $mode = (new ModeDeJeuRepository())->recupererParClePrimaire($_REQUEST["mode"]);
                    /** @var Classement $classement */
                    $classement = (new ClassementRepository())->recupererParClePrimaire($_REQUEST["class"]);
                    if ($jeu == null) {
                        MessageFlash::ajouter("danger", "Le jeu n'existe pas.");
                        self::redirectionVersURL();
                    } else if ($mode == null) {
                        MessageFlash::ajouter("danger", "Le mode n'existe pas.");
                        self::redirectionVersURL();
                    } else if ($classement == null) {
                        MessageFlash::ajouter("danger", "Le classement n'existe pas.");
                        self::redirectionVersURL();
                    } else {
                        $jouerRepo = new jouerRepository();
                        if ($jouerRepo->existeTuple(array($_REQUEST['jeu'], $_REQUEST['id'], $_REQUEST['mode']))) {
                            $jouerRepo->supprimerTuple(array($_REQUEST['jeu'], $_REQUEST['id'], $_REQUEST['mode']));
                        }
                        $jouerRepo->ajouterTuple(array($_REQUEST['jeu'],$_REQUEST['id'], $_REQUEST['mode'], $_REQUEST['class']));
                        MessageFlash::ajouter("success", "Jeu ajouté !");
                        self::redirectionVersURL("afficherDetail&id=" . $_REQUEST['id'], "utilisateur");
                    }
                }
            }
        }
    }

}