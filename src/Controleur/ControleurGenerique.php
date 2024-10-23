<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\PreferenceControleur;

abstract class ControleurGenerique {

    protected static function afficherVue(string $cheminVue, array $parametres = []) : void{
        extract($parametres);
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../vue/$cheminVue";
    }

    public static function afficherFormulairePreference() : void{
        self::afficherVue("formulairePreference.php");
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
}