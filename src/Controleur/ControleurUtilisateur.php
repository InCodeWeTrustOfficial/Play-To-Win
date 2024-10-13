<?php
namespace App\Covoiturage\Controleur;
//require_once __DIR__ . '/../Modele/ModeleUtilisateur.php';
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
class ControleurUtilisateur {

    private static function afficherVue(string $cheminVue, array $parametres = []) : void{
        extract($parametres);
        require __DIR__ . "/../vue/$cheminVue";
    }

    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        $controleur = "utilisateur";
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php", 'utilisateurs'=>$utilisateurs, 'controleur'=>$controleur]);
    }

    public static function afficherDetail() : void {
        if(!isset( $_GET['login'])){
            self::afficherErreur();
        }else{
            $login = $_GET['login'];
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
            if($utilisateur != NULL) {
                $controleur = "utilisateur";
                self::afficherVue('vueGenerale.php',["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php", 'utilisateur'=>$utilisateur,'controleur'=>$controleur]);
            } else{
                $loginHTML = htmlspecialchars($login);
                self::afficherErreur($loginHTML);
            }
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        $controleur = "utilisateur";
        if(!$messageErreur == ""){
            $messageErreur = ': '.$messageErreur;
        }
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec l'utilisateur", "cheminCorpsVue" => "utilisateur/erreur.php", "messageErreur" => $messageErreur,'controleur'=>$controleur]);
    }

    public static function afficherFormulaireCreation() : void{
        $controleur = "utilisateur";
        self::afficherVue('vueGenerale.php',["titre" => "Formulaire création utilisateur", "cheminCorpsVue" => 'utilisateur/formulaireCreation.php','controleur'=>$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void{
        $controleur = "utilisateur";
        if(!isset( $_GET['login'])){
            self::afficherErreur("Erreur, l'utilisateur n'existe pas !");
        } else{
            $login = $_GET['login'];
            self::afficherVue('vueGenerale.php', ["titre"=>"Formulaire de MAJ", "cheminCorpsVue" => 'utilisateur/formulaireMiseAJour.php', 'login'=>$login,'controleur'=>$controleur]);
        }
    }

    public static function creerDepuisFormulaire() : void{
        $controleur = "utilisateur";
        $utilisateur = new Utilisateur($_GET['login'],$_GET['nom'],$_GET['prenom']);
        (new UtilisateurRepository)->ajouter($utilisateur);
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue('vueGenerale.php', ["titre" => "Création utilisateur", "cheminCorpsVue" => 'utilisateur/utilisateurCree.php', 'utilisateurs'=>$utilisateurs,'controleur'=>$controleur]);
    }

    public static function supprimer() : void{
        $controleur = "utilisateur";
        if(isset($_GET['login'])){
            (new UtilisateurRepository())->supprimer($_GET['login']);
            $utilisateurs = (new UtilisateurRepository())->recuperer();
            $loginHTML = htmlspecialchars($_GET['login']);
            self::afficherVue('vueGenerale.php', ["titre" => "Suppression utilisateur", "cheminCorpsVue" => 'utilisateur/utilisateurSupprime.php', 'utilisateurs'=>$utilisateurs, 'login'=>$loginHTML,'controleur'=>$controleur]);
        } else{
            self::afficherErreur("Erreur, l'utilisateur n'existe pas !");
        }
    }

    public static function mettreAJour() : void{
        $controleur = "utilisateur";
        if(!isset($_GET['login']) || !isset($_GET['nom']) || !isset($_GET['prenom'])){
            self::afficherErreur("Erreur, les informations ne sont pas complètes !");
        } else {
            $utilisateur = (new UtilisateurRepository)->construireDepuisTableauSQL([$_GET['login'],$_GET['nom'],$_GET['prenom']]);
            (new UtilisateurRepository())->mettreAJour($utilisateur);
            $loginHTML = htmlspecialchars($_GET['login']);
            $utilisateurs = (new UtilisateurRepository())->recuperer();
            self::afficherVue('vueGenerale.php', ["titre" => "Modification utilisateur", "cheminCorpsVue" => 'utilisateur/utilisateurMisAJour.php', 'login'=>$loginHTML, 'utilisateurs'=>$utilisateurs,'controleur'=>$controleur]);
        }
    }
}
?>