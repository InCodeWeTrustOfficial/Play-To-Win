<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\PreferenceControleur;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;

abstract class ControleurGenerique {

    public static function afficherErreur(string $msg = null) : void{
        if($msg === null){
            $msg = "Nous rencontrons une erreur dans le chargement de la page.";
        }
        $msg = htmlspecialchars($msg);
        self::afficherVue("vueGenerale.php",["titre" => "Problème détecté !", "cheminCorpsVue" => "erreur.php", "message" => $msg]);
    }

    protected static function afficherVue(string $cheminVue, array $parametres = []) : void{
        extract($parametres);
        $messagesFlash = MessageFlash::lireTousMessages();
        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        $estCoach = ConnexionUtilisateur::estConnecte() && (new CoachRepository())->estCoach(ConnexionUtilisateur::getIdUtilisateurConnecte());
        $estConnecte = ConnexionUtilisateur::estConnecte();
        if($estConnecte){
            $idUtilisateur = ConnexionUtilisateur::getIdUtilisateurConnecte();
            $idURL = rawurlencode($idUtilisateur);
        }
        require __DIR__ . "/../vue/$cheminVue";
    }

    public static function afficherFormulairePreference() : void{
        $preferenceExiste = PreferenceControleur::existe();
        $controleurPref = null;
        if($preferenceExiste){
            $controleurPref = PreferenceControleur::lire();
        }
        $conf = ConfigurationSite::getDebug()?"get":"post";
        self::afficherVue("vueGenerale.php",["cheminCorpsVue" => "formulairePreference.php","preferenceExiste" => $preferenceExiste, "controleurPref" => $controleurPref, "conf" => $conf]);
    }

    public static function enregistrerPreference() : void{
        $preference = $_REQUEST["controleur_defaut"];
        PreferenceControleur::enregistrer($preference);
        MessageFlash::ajouter("success","Votre préférence a été enregistrée !");
        self::redirectionVersURL();
    }
    public static function redirectionVersURL($url = null,$controleur = null):void{
        $msg = "Location: ".ConfigurationSite::getURLAbsolue()."?";
        if($controleur != null){
            $msg.="controleur=".$controleur."&";
        }
        if($url != null){
            $msg.="action=";
        }
        header($msg.$url);
        exit();
    }

    protected static function existePasRequest(array $args, string $message, string $url = null, string $controleur = null):bool{
        $verif = false;
        foreach ($args as $arg){
            if($_REQUEST[$arg] === null){
                $verif = true;
                break;
            }
        }
        if($verif){
            MessageFlash::ajouter("danger",htmlspecialchars($message));
            static::redirectionVersURL($url,$controleur);
        }
        return $verif;
    }

    protected static function nestPasBonUtilisateur(string $id,string $url = null, string $controleur = null) : bool{
        $verif = !ConnexionUtilisateur::estBonUtilisateur($id);

        if($verif){
            MessageFlash::ajouter("danger","Vous n'avez pas les permissions nécessaires.");
            static::redirectionVersURL($url, $controleur);
        }

        return $verif;
    }
}