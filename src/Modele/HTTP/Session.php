<?php

namespace App\Covoiturage\Modele\HTTP;

use App\Covoiturage\Configuration\ConfigurationSite;
use Exception;
use App\Covoiturage\Configuration\ConfigurationBaseDeDonnees;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance))
            Session::$instance = new Session();
        self::verifierDerniereActivite();
        return Session::$instance;
    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, mixed $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed
    {
        return $_SESSION[$nom] ?? null;
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
    }

    public function detruire() : void
    {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        Cookie::supprimer(session_name()); // deletes the session cookie
        // Il faudra reconstruire la session au prochain appel de getInstance()
        Session::$instance = null;
    }

    public static function verifierDerniereActivite() : void{
        if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > (ConfigurationSite::getDureeExpiration())))
            session_unset();     // unset $_SESSION variable for the run-time

        $_SESSION['derniereActivite'] = time(); // update last activity time stamp

    }
}

