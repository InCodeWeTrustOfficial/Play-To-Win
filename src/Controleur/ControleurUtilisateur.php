<?php
namespace App\Covoiturage\Controleur;
//require_once __DIR__ . '/../Modele/ModeleUtilisateur.php';
use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Lib\MotDePasse;
use App\Covoiturage\Lib\VerificationEmail;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\HTTP\Session;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\HTTP\Cookie;
use DateTime;

class ControleurUtilisateur extends ControleurGenerique {

    private static string $controleur = "utilisateur";

    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php", 'utilisateurs'=>$utilisateurs, 'controleur'=>self::$controleur]);
    }

    public static function afficherDetail() : void {
        if(!isset( $_REQUEST['id'])){
            self::afficherErreur();
        }else{
            $id = $_REQUEST['id'];
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
            if($utilisateur != NULL) {
                self::afficherVue('vueGenerale.php',["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php", 'utilisateur'=>$utilisateur,'controleur'=>self::$controleur]);
            } else{
                $idHTML = htmlspecialchars($id);
                self::afficherErreur($idHTML);
            }
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if(!$messageErreur == ""){
            $messageErreur = ': '.$messageErreur;
        }
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec l'utilisateur", "cheminCorpsVue" => "utilisateur/erreur.php", "messageErreur" => $messageErreur,'controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireCreation() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Formulaire création utilisateur", "cheminCorpsVue" => 'utilisateur/formulaireCreation.php','controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void{
        if(!isset( $_REQUEST['id'])){
            self::afficherErreur("Erreur, l'utilisateur n'existe pas !");
        } else{
            if(!ConnexionUtilisateur::estConnecte()) {
                self::afficherErreur("La mise à jour n'est possible que pour l'utilisateur connecté.");

            } else{
                $id = $_REQUEST['id'];
                if(!ConnexionUtilisateur::estAdministrateur()){
                    $id = ConnexionUtilisateur::getIdUtilisateurConnecte();
                }
                self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'utilisateur/formulaireMiseAJour.php', 'id' => $id, 'controleur' => self::$controleur]);
            }
        }
    }

    public static function afficherFormulaireConnexion() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Connexion Utilisateur", "cheminCorpsVue" => 'utilisateur/formulaireConnexion.php']);
    }

    public static function connecter() : void{
        if (!isset($_REQUEST["id"]) || !isset($_REQUEST["mdp"])){
            self::afficherErreur("Formulaire incomplet !");
        } else{
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST["id"]);
            if($utilisateur == null || !MotDePasse::verifier($_REQUEST["mdp"],$utilisateur->getMdpHache())){
                self::afficherErreur("id et/ou mot de passe incorrect");
            } else{
                if(!VerificationEmail::aValideEmail($utilisateur)){
                    self::afficherErreur("Vous devez valider le mail !");
                }else {
                    ConnexionUtilisateur::connecter($utilisateur->getId());
                    self::afficherVue("vueGenerale.php", ["titre" => "Utilisateur connecte", "cheminCorpsVue" => "utilisateur/utilisateurConnecte.php", 'utilisateur' => $utilisateur]);
                }
            }
        }
    }

    public static function deconnecter(): void{
        ConnexionUtilisateur::deconnecter();
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue("vueGenerale.php",["titre" => "Deconnexion Utilisateur","cheminCorpsVue" => "utilisateur/utilisateurDeconnecte.php", 'utilisateurs' => $utilisateurs, 'controleur'=>self::$controleur]);
    }

    public static function creerDepuisFormulaire() : void{
        if($_REQUEST["mdp"] != $_REQUEST["mdp2"]){
            self::afficherErreur("Mots de passe distincts");
        } else{
            if(!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)){
                self::afficherErreur("Email invalide");
            } else {
                if (!ConnexionUtilisateur::estAdministrateur()) {
                    unset($_REQUEST["estAdmin"]);
                }
                $utilisateur = self::construireDepuisFormulaire($_REQUEST);
                (new UtilisateurRepository)->ajouter($utilisateur);
                $utilisateurs = (new UtilisateurRepository())->recuperer();
                self::afficherVue('vueGenerale.php', ["titre" => "Création utilisateur", "cheminCorpsVue" => 'utilisateur/utilisateurCree.php', 'utilisateurs' => $utilisateurs, 'controleur' => self::$controleur]);
            }
        }
    }

    public static function supprimer() : void {
        if (!isset($_REQUEST['id'])) {
            self::afficherErreur("id inexistant !");
        } else {
            if (!ConnexionUtilisateur::estConnecte()) {
                self::afficherErreur("Vous devez être connecté");
            } else {
                if (ConnexionUtilisateur::getIdUtilisateurConnecte() != $_REQUEST['id'] && !ConnexionUtilisateur::estAdministrateur()) {
                    self::afficherErreur("id non valide !");
                } else {
                    if(!ConnexionUtilisateur::estAdministrateur()){ConnexionUtilisateur::deconnecter();}
                    (new UtilisateurRepository())->supprimer($_REQUEST['id']);
                    $utilisateurs = (new UtilisateurRepository())->recuperer();
                    $idHTML = htmlspecialchars($_REQUEST['id']);
                    self::afficherVue('vueGenerale.php', ["titre" => "Suppression utilisateur", "cheminCorpsVue" => 'utilisateur/utilisateurSupprime.php', 'utilisateurs' => $utilisateurs, 'id' => $idHTML, 'controleur' => self::$controleur]);
                }
            }
        }
    }

    public static function mettreAJour() : void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['nom']) || !isset($_REQUEST['prenom']) || !isset($_REQUEST['pseudo']) || !isset($_REQUEST['date']) || !isset($_REQUEST['amdp']) || !isset($_REQUEST['mdp']) || !isset($_REQUEST['mdp2'])){
            self::afficherErreur("Erreur, les informations ne sont pas complètes !");
        } else {
            /** @var Utilisateur $utilPossible */
            $utilPossible = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['id']);
            if($utilPossible == null || ($utilPossible->getId() != ConnexionUtilisateur::getIdUtilisateurConnecte() && !ConnexionUtilisateur::estAdministrateur())){
                self::afficherErreur("Utilisateur non valide !");
            } else {
                if($_REQUEST['mdp'] != $_REQUEST['mdp2']){
                    self::afficherErreur("Les mots de passe ne sont pas identiques !");
                } else {
                    if(!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['amdp'],$utilPossible->getMdpHache())){
                        self::afficherErreur("Ancien mot de passe incorrect");
                    } else {
                        $boolMail = false;
                        if(isset($_REQUEST["email"]) && $_REQUEST["email"] != $utilPossible->getEmail()){
                            if(filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)){
                                $boolMail = true;
                                $utilPossible->setEmailAValider($_REQUEST["email"]);
                                $utilPossible->setNonce(MotDePasse::genererChaineAleatoire());
                            }
                        }
                        $utilPossible->setNom($_REQUEST['nom']);
                        $utilPossible->setPrenom($_REQUEST['prenom']);
                        $utilPossible->setPseudo($_REQUEST['pseudo']);
                        $utilPossible->setDateNaissance(new DateTime($_REQUEST['date']));
                        $utilPossible->setMdpHache(MotDePasse::hacher($_REQUEST['mdp']));
                        if(ConnexionUtilisateur::estAdministrateur()){
                            $utilPossible->setAdmin(isset($_REQUEST['estAdmin']));
                        }
                        (new UtilisateurRepository())->mettreAJour($utilPossible);
                        if($boolMail){VerificationEmail::envoiEmailValidation($utilPossible);}
                        $idHTML = htmlspecialchars($_REQUEST['id']);
                        $utilisateurs = (new UtilisateurRepository())->recuperer();
                        self::afficherVue('vueGenerale.php', ["titre" => "Modification utilisateur", "cheminCorpsVue" => 'utilisateur/utilisateurMisAJour.php', 'id' => $idHTML, 'utilisateurs' => $utilisateurs, 'controleur' => self::$controleur]);
                    }
                }
            }
        }
    }

    public static function validerEmail() : void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['nonce'])){
            self::afficherErreur("Problème avec le mail");
        } else{
            if(!VerificationEmail::traiterEmailValidation($_REQUEST['id'], $_REQUEST['nonce'])){
                self::afficherErreur("Erreur bip boup");
            } else{
                self::afficherDetail();
            }
        }
    }

    /**
     * @return Utilisateur
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur {
        $mdpHache = MotDePasse::hacher($tableauDonneesFormulaire['mdp']);
        $utilisateur = new Utilisateur($tableauDonneesFormulaire['id'], $tableauDonneesFormulaire['nom'], $tableauDonneesFormulaire['prenom'],$tableauDonneesFormulaire['pseudo'],"",$tableauDonneesFormulaire['email'],MotDePasse::genererChaineAleatoire(), new DateTime($tableauDonneesFormulaire['dateDeNaissance']), $mdpHache, isset($tableauDonneesFormulaire['estAdmin']),"");
        VerificationEmail::envoiEmailValidation($utilisateur);
        return $utilisateur;
    }
}
?>