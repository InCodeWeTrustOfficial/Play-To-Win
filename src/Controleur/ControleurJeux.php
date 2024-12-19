<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class ControleurJeux extends ControleurGenerique {

    public static string $controleur = "jeux";

    public static function afficherListe():void{
        $jeux = (new JeuRepository())->recuperer();
        self::afficherVue("vueGenerale.php",["titre" => "Nos jeux!","cheminCorpsVue" => "jeux/liste.php", "jeux" => $jeux]);
    }

}