<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Lib\MotDePasse;
use App\Covoiturage\Lib\VerificationEmail;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;

class ControleurService extends ControleurGenerique {

    private static string $controleur = "service";

    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php", 'utilisateurs'=>$utilisateurs, 'controleur'=>self::$controleur]);
    }

    public static function afficherDetail() : void {
        if(!isset( $_REQUEST['login'])){
            self::afficherErreur();
        }else{
            $login = $_REQUEST['login'];
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if($utilisateur != NULL) {
                self::afficherVue('vueGenerale.php',["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php", 'utilisateur'=>$utilisateur,'controleur'=>self::$controleur]);
            } else{
                $loginHTML = htmlspecialchars($login);
                self::afficherErreur($loginHTML);
            }
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if(!$messageErreur == ""){
            $messageErreur = ': '.$messageErreur;
        }
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec l'utilisateur", "cheminCorpsVue" => "utilisateur/erreur.php", "messageErreur" => $messageErreur,'controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireProposerService() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Proposition services", "cheminCorpsVue" => 'service/formulaireCreation.php']);
    }

    /**
     * Permet a l'utilisateur de proposer un services (coaching / analyse vidéo)
     * @return void
     */
    private static function proposerService() : void{

        $service = self::construireDepuisFormulaire($_REQUEST);
        (new UtilisateurRepository)->ajouter($service);
        $services = (new UtilisateurRepository())->recuperer();
        self::afficherVue('vueGenerale.php', ["titre" => "Création service", "cheminCorpsVue" => 'service/utilisateurCree.php', 'utilisateurs' => $services, 'controleur' => self::$controleur]);
    }

    /**
     * @return Services
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur {
        $mdpHache = MotDePasse::hacher($tableauDonneesFormulaire['mdp']);
        $utilisateur = new Utilisateur($tableauDonneesFormulaire['login'], $tableauDonneesFormulaire['nom'], $tableauDonneesFormulaire['prenom'], $mdpHache, isset($tableauDonneesFormulaire['estAdmin']),"",$tableauDonneesFormulaire['email'],MotDePasse::genererChaineAleatoire());
        VerificationEmail::envoiEmailValidation($utilisateur);
        return $utilisateur;
    }


}