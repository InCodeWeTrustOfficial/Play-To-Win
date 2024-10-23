<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\PreferenceControleur;

abstract class ControleurGenerique {

    protected static function afficherVue(string $cheminVue, array $parametres = []) : void{
        extract($parametres);
        require __DIR__ . "/../vue/$cheminVue";
    }

    public static function afficherFormulairePreference() : void{
        self::afficherVue("formulairePreference.php");
    }

    public static function enregistrerPreference() : void{
        $preference = $_REQUEST["controleur_defaut"];
        PreferenceControleur::enregistrer($preference);
        self::afficherVue("preferenceEnregistree.php",["preference" => $preference]);
    }
}