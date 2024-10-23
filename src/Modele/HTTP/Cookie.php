<?php

namespace App\PlayToWin\Modele\HTTP;

class Cookie {
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null) : void{
        $stringValeur = serialize($valeur);
        if($dureeExpiration == null){
            setcookie($cle,$stringValeur,0);
        } else{
            setcookie($cle,$stringValeur,$dureeExpiration);
        }
    }
    public static function lire(string $cle) : mixed{
        return unserialize($_COOKIE[$cle]);
    }

    public static function contient($cle) : bool{
        return isset($_COOKIE[$cle]);
    }
    public static function supprimer($cle) : void{
        setcookie($cle,'',1);
    }
}