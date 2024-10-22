<?php

namespace App\Covoiturage\Configuration;

class ConfigurationSite {
    static private array $configurationSite = array(
        'dureeExpiration' => 3600,
        'enDev' => false
    );

    static public function getDureeExpiration():int{
        return ConfigurationSite::$configurationSite['dureeExpiration'];
    }
    public static function getURLAbsolue():string{
        return "http://localhost/s3-projetweb/web/controleurFrontal.php";
    }

    public static function getDebug():bool{
        return ConfigurationSite::$configurationSite['enDev'];
    }

}