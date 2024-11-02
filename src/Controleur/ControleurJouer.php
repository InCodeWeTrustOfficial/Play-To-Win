<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\AvoirModeRepository;
use App\PlayToWin\Modele\Repository\Association\SeClasserRepository;
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

                    $jouerRepo->supprimerTuple(array($_REQUEST['jeu'],$_REQUEST["id"], $_REQUEST["mode"]));
                    MessageFlash::ajouter("success","suppression du jeu ".htmlspecialchars($jeu->getNomJeu())." dans le mode ".htmlspecialchars($mode->getNomMode()));

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

                $modesDunJeu = (new AvoirModeRepository())->recupererMap();
                // [rl => ["1v1","2v2","3v3"] , lol => ["faille"]]
                //  str     obj   obj   obj     str      obj

                $utilisateurModesJoues = (new JouerRepository())->recupererModeJeuClassement($_REQUEST["id"]);
                // ["rl","1v1","38"]
                // ["rl","2v2","37"]
                //   obj   obj  obj

                if ($utilisateurModesJoues != null) {
                    foreach ($utilisateurModesJoues as $modesJoue) {
                        $tab = $modesDunJeu[$modesJoue[0]->getCodeJeu()];
                        if (($key = array_search($modesJoue[1], $tab)) !== false) {
                            unset($tab[$key]);
                        }
                        if(count($tab) != 0) {
                            $modesDunJeu[$modesJoue[0]->getCodeJeu()] = $tab;
                        } else{
                            unset($modesDunJeu[$modesJoue[0]->getCodeJeu()]);
                        }
                    }
                }
                // [rl => ["3v3], lol => ["faille"]]
                //var_dump($modesDunJeu);

                $classementsPossibles = array();
                $jeux = array();

                foreach(array_keys($modesDunJeu) as $key){
                    $classementsPossibles[$key] = (new SeClasserRepository())->recupererAvecJeu($key);
                    $jeux[] = (new JeuRepository())->recupererParClePrimaire($key);
                }
                // [rl => [liste des classements], lol => [liste des classements]]


                // need : modesDunJeu et classementsPossibles
                $jeu = null;
                if(isset($_REQUEST['jeu'])){
                    $jeu = (new JeuRepository())->recupererParClePrimaire($_REQUEST['jeu']);
                }

                self::afficherVue("vueGenerale.php",["titre" => "Ajout d'un jeu","cheminCorpsVue" => "jouer/formulaireJouer.php","jeu" => $jeu,"idUser" => $_REQUEST["id"], "jeux" => $jeux,"modesDunJeu" => $modesDunJeu, "classementsPossibles" => $classementsPossibles]);
            }
        }
    }

    public static function ajouterJouer():void{
        if (isset($_REQUEST["jeu"]) && $_REQUEST['jeu'] != 'rien' && isset($_REQUEST["id"]) && !isset($_REQUEST['mode']) && !isset($_REQUEST["class"])){
            $jeuUrl = rawurldecode($_REQUEST["jeu"]);
            $idUrl = rawurldecode($_REQUEST["id"]);
            self::redirectionVersURL("afficherFormulaireJouer&id=".$idUrl."&jeu=".$jeuUrl, self::$controleur);
        } else if(!isset($_REQUEST["jeu"]) || !isset($_REQUEST["id"]) || !isset($_REQUEST["mode"]) || !isset($_REQUEST['class'])){
            MessageFlash::ajouter("danger","Infos manquantes.");
            self::redirectionVersURL();
        } else{
            if(!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))){
                MessageFlash::ajouter("danger","Vous n'avez pas les droits de faire ceci !");
                self::redirectionVersURL();
            } else{
                $idUrl = rawurldecode($_REQUEST["id"]);
                $jeuUrl = rawurldecode($_REQUEST["jeu"]);
                if($_REQUEST['jeu'] == "rien"){
                    MessageFlash::ajouter("info","Sélectionnez un jeu !");
                    self::redirectionVersURL("afficherFormulaireJouer&id=".$idUrl, self::$controleur);
                } else if($_REQUEST['mode'] == "rien"){
                    MessageFlash::ajouter("info","Sélectionnez un mode !");
                    self::redirectionVersURL("afficherFormulaireJouer&id=".$idUrl."&jeu=".$jeuUrl, self::$controleur);
                } else if($_REQUEST['class'] == "rien"){
                    MessageFlash::ajouter("info","Sélectionnez un classement !");
                    self::redirectionVersURL("afficherFormulaireJouer&id=".$idUrl."&jeu=".$jeuUrl, self::$controleur);
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
                        self::redirectionVersURL("afficherDetail&id=" . $idUrl, "utilisateur");
                    }
                }
            }
        }
    }

}