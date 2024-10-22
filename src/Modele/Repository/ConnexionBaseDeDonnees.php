<?php
namespace App\Covoiturage\Modele\Repository;
//require_once __DIR__ . '/../Configuration/ConfigurationBaseDeDonnees.php';
use App\Covoiturage\Configuration\ConfigurationBaseDeDonnees;
use \PDO as PDO;

class ConnexionBaseDeDonnees {

    private static ?ConnexionBaseDeDonnees $instance = null;
    private PDO $pdo;

    private function __construct() {

        $nomHote = ConfigurationBaseDeDonnees::getNomHote();
        $port = ConfigurationBaseDeDonnees::getPort();
        $nomBaseDeDonnees = ConfigurationBaseDeDonnees::getNomBaseDeDonnees();
        $login = ConfigurationBaseDeDonnees::getId();
        $motDePasse = ConfigurationBaseDeDonnees::getPassword();

        $this->pdo = new PDO("mysql:host=$nomHote;port=$port;dbname=$nomBaseDeDonnees",$login,$motDePasse,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    private static function getInstance() : ConnexionBaseDeDonnees {

        if (is_null(ConnexionBaseDeDonnees::$instance))
            ConnexionBaseDeDonnees::$instance = new ConnexionBaseDeDonnees();
        return ConnexionBaseDeDonnees::$instance;
    }

    public static function getPdo(): PDO {
        return ConnexionBaseDeDonnees::getInstance()->pdo;
    }


}