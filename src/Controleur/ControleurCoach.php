<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\MotDePasse;
use App\PlayToWin\Lib\VerificationEmail;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\CoachRepository;
use App\PlayToWin\Modele\Repository\UtilisateurRepository;

class ControleurCoach extends ControleurGenerique {

    private static string $controleur = "coach";

    public static function afficherListe() : void {
        $utilisateurs = (new CoachRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "coach/liste.php", 'coachs'=>$utilisateurs, 'controleur'=>self::$controleur]);
    }
    
    public static function afficherDetail() : void{
        if(!isset($_REQUEST['id'])){
            MessageFlash::ajouter("warning","Le coach n'existe pas.");
            self::redirectionVersURL();
        } else{
            $id = $_REQUEST['id'];
            $idHtml = htmlspecialchars($id);
            if(!(new CoachRepository())->estCoach($id)){
                MessageFlash::ajouter("warning","$idHtml n'est pas un coach.");
                self::redirectionVersURL();
            }else{
                $coach = (new CoachRepository())->recupererParClePrimaire($id);
                self::afficherVue("vueGenerale.php",["titre" => "Informations Coach","cheminCorpsVue" => "coach/detail.php", "coach" => $coach]);
            }
        }
    }

    public static function afficherFormulaireCreation(): void{
        if(!isset($_REQUEST['id'])){
            MessageFlash::ajouter("warning","Aucun utilisateur.");
            self::redirectionVersURL();
        } else{
            if((new CoachRepository())->estCoach($_REQUEST['id'])){
                $idHtml = htmlspecialchars($_REQUEST['id']);
                MessageFlash::ajouter("info","Le coach $idHtml est déjà inscrit !");
            } else{
                /** @var Utilisateur $utilisateur */
                $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['id']);
                if($utilisateur == null){
                    MessageFlash::ajouter("danger", "L'utilisateur n'existe pas.");
                } else{
                    if(!(ConnexionUtilisateur::estConnecte() && (ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) || ConnexionUtilisateur::estAdministrateur()))){
                        MessageFlash::ajouter("danger","Vous n'avez pas la permission de faire ceci.");
                        self::redirectionVersURL();
                    }else{
                        if(ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) && !VerificationEmail::aValideEmail($utilisateur) && !ConnexionUtilisateur::estAdministrateur()){
                            MessageFlash::ajouter("info","Un coach doit avoir validé son mail.");
                            self::redirectionVersURL("afficherDetail","utilisateur");
                        } else{
                            self::afficherVue("vueGenerale.php",["titre" => "Formulaire création coach","cheminCorpsVue" => "coach/formulaireCreation.php","utilisateur" => $utilisateur,"controleur" => self::$controleur]);
                        }
                    }
                }
            }
        }
    }

    public static function afficherFormulaireMiseAJour():void{
        if(!isset($_REQUEST['id'])){
            MessageFlash::ajouter("danger","AucuAjout image testn id.");
            self::redirectionVersURL();
        } else{
            if(!(ConnexionUtilisateur::estAdministrateur() || ConnexionUtilisateur::estUtilisateur($_REQUEST['id']))){
                MessageFlash::ajouter("danger","Vous n'êtes pas le bon utilisateur.");
            } else{
                $coach = (new CoachRepository())->recupererParClePrimaire($_REQUEST['id']);
                self::afficherVue("vueGenerale.php",["titre" => "Mise a jour du coach","cheminCorpsVue" => "coach/formulaireMiseAJour.php","coach"=>$coach]);
            }
        }
    }

    public static function creerDepuisFormulaire() : void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['pseudo']) || !isset($_REQUEST['biographie']) || !isset($_REQUEST['mdp'])){
            MessageFlash::ajouter("danger","Il manque des informations.");
            self::redirectionVersURL();
        } else{
            /** @var Utilisateur $utilisateur */
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire(ConnexionUtilisateur::getIdUtilisateurConnecte());
            $idUrl = rawurlencode($_REQUEST['id']);
            if(!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['mdp'],$utilisateur->getMdpHache())){
                MessageFlash::ajouter("warning","Mot de passe incorect");
                self::redirectionVersURL("afficherFormulaireCreation&id=$idUrl",self::$controleur);
            } else{
                $coach = self::construireDepuisFormulaire($_REQUEST);
                (new CoachRepository())->ajouter($coach);
                $msg = "Vous êtes dorénavant enregistré en tant que coach";
                if(ConnexionUtilisateur::estAdministrateur()){
                    $msg = "Enregistrement du nouveau coach";
                }
                MessageFlash::ajouter("success",$msg);
                self::redirectionVersURL("afficherDetail&id=$idUrl",self::$controleur);
            }
        }
    }

    public static function mettreAJour():void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['biographie']) || !isset($_REQUEST['mdp'])){
            MessageFlash::ajouter("danger","Il manque des informations.");
            self::redirectionVersURL();
        } else{
            if(!(ConnexionUtilisateur::estAdministrateur() || ConnexionUtilisateur::estUtilisateur($_REQUEST['id']))){
                MessageFlash::ajouter("danger","Vous n'êtes pas le bon utilisateur.");
                self::redirectionVersURL();
            } else{
                /** @var Coach $coach */
                $coach = (new CoachRepository())->recupererParClePrimaire($_REQUEST['id']);
                $idUrl = rawurlencode($_REQUEST['id']);
                if(ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) && !MotDePasse::verifier($_REQUEST['mdp'],$coach->getMdpHache())){
                    MessageFlash::ajouter("warning","Mot de passe incorrect.");
                    self::redirectionVersURL("afficherFormulaireMiseAJour&id=$idUrl",self::$controleur);
                } else{
                    $coach->setBiographie($_REQUEST['biographie']);
                    (new CoachRepository())->mettreAJour($coach);
                    MessageFlash::ajouter("success","Informations mises à jour !");
                    self::redirectionVersURL("afficherDetail&id=$idUrl",self::$controleur);
                }
            }
        }
    }

    public static function supprimer() : void {
        if (!isset($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Login non valide.");
            self::redirectionVersURL();
        } else {
            if (!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estUtilisateur($_REQUEST['id'])) {
                MessageFlash::ajouter("danger","Vous n'êtes pas le bon utilisateur.");
                self::redirectionVersURL();
            } else {
                (new CoachRepository())->supprimer($_REQUEST['id']);
                $idHtml = htmlspecialchars($_REQUEST['id']);
                MessageFlash::ajouter("success", "Compte $idHtml désinscrit des coachs !");
                self::redirectionVersURL("afficherListe", "utilisateur");
            }
        }
    }

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Coach {
        return new Coach((new UtilisateurRepository())->recupererParClePrimaire($tableauDonneesFormulaire['id']), $tableauDonneesFormulaire['biographie']);
    }

}