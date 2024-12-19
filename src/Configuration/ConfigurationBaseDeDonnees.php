<?php
namespace App\PlayToWin\Configuration;

class ConfigurationBaseDeDonnees {
    static private array $configurationBaseDeDonnees = array(
        'nomHote' => 'nomDeLhote',
        'nomBaseDeDonnees' => 'lui',
        'port' => '1111',
        'login' => 'moi',
        'motDePasse' => 'mdpCompliqué',
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
