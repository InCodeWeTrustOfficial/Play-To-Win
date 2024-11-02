<?php
namespace App\PlayToWin\Configuration;

class ConfigurationBaseDeDonnees {
    static private array $configurationBaseDeDonnees = array(
        'nomHote' => 'db',
        'nomBaseDeDonnees' => 'turpinb',
        'port' => '3306',
        'login' => 'root',
        'motDePasse' => 'notSecureChangeMe',
    );

    static public function getId():string{
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['login'];
    }
    static public function getNomHote():string{
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomHote'];
    }
    static public function getPort():string{
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['port'];
    }
    static public function getNomBaseDeDonnees():string{
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomBaseDeDonnees'];
    }
    static public function getPassword():string{
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['motDePasse'];
    }
}
