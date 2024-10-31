<?php
namespace App\PlayToWin\Configuration;

class ConfigurationBaseDeDonnees {
    /**
    static private array $configurationBaseDeDonnees = array(
        'nomHote' => 'webinfo.iutmontp.univ-montp2.fr',
        'nomBaseDeDonnees' => 'turpinb',
        'port' => '3316',
        'login' => 'turpinb',
        'motDePasse' => '080482285HA',
    );
     * */
    static private array $configurationBaseDeDonnees = array(
        'nomHote' => 'host.docker.internal',
        'nomBaseDeDonnees' => 'turpinb',
        'port' => '3306',
        'login' => 'turpinb',
        'motDePasse' => '080482285HA'
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
