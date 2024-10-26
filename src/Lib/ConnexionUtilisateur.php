<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $idUtilisateur): void
    {
        Session::getInstance()->enregistrer(self::$cleConnexion, $idUtilisateur);
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(self::$cleConnexion);
    }

    public static function getIdUtilisateurConnecte(): ?string
    {
        return Session::getInstance()->lire(self::$cleConnexion);
    }
    public static function estUtilisateur($id) : bool{
        return self::getIdUtilisateurConnecte() == $id;
    }
    public static function estAdministrateur() : bool{
        if(self::estConnecte()){
            $user = (new UtilisateurRepository())->recupererParClePrimaire(self::getIdUtilisateurConnecte());
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

