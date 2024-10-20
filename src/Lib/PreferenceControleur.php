<?php

namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\HTTP\Cookie;

class PreferenceControleur {
    private static string $clePreference = "preferenceControleur";

    public static function enregistrer(string $preference) : void
    {
        Cookie::enregistrer(PreferenceControleur::$clePreference, $preference);
    }

    public static function lire() : string
    {
        return Cookie::lire(PreferenceControleur::$clePreference);
    }

    public static function existe() : bool
    {
        return Cookie::contient(PreferenceControleur::$clePreference);
    }

    public static function supprimer() : void
    {
        Cookie::supprimer(PreferenceControleur::$clePreference);
    }
}

