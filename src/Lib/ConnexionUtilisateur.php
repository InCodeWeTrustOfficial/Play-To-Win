<?php

namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\HTTP\Session;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        Session::getInstance()->enregistrer(self::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(self::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        return Session::getInstance()->lire(self::$cleConnexion);
    }
    public static function estUtilisateur($login) : bool{
        return self::getLoginUtilisateurConnecte() == $login;
    }
    public static function estAdministrateur() : bool{
        if(self::estConnecte()){
            $user = (new UtilisateurRepository())->recupererParClePrimaire(self::getLoginUtilisateurConnecte());
            if($user != null && $user->isAdmin()){
                return true;
            } else{
                return false;
            }
        } else{
            return false;
        }
    }
}

