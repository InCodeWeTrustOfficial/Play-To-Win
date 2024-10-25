<?php
namespace App\PlayToWin\Controleur;
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\MotDePasse;
use App\PlayToWin\Lib\VerificationEmail;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\UtilisateurRepository;
use DateTime;

class ControleurUtilisateur extends ControleurGenerique {

    private static string $controleur = "utilisateur";

    public static function afficherListe() : void {
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php", 'utilisateurs'=>$utilisateurs, 'controleur'=>self::$controleur]);
    }

    public static function afficherDetail() : void {
        if(!isset( $_REQUEST['id'])){
            MessageFlash::ajouter("warning","L'utilisateur est inexistant !");
            self::redirectionVersURL("afficherListe",self::$controleur);
        }else{
            $id = $_REQUEST['id'];
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
            if($utilisateur != NULL) {
                self::afficherVue('vueGenerale.php',["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php", 'utilisateur'=>$utilisateur,'controleur'=>self::$controleur]);
            } else{
                $idHTML = htmlspecialchars($id);
                MessageFlash::ajouter("warning","L'utilisateur $idHTML n'existe pas !");
                self::redirectionVersURL("afficherListe",self::$controleur);
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
            MessageFlash::ajouter("danger","Login non valide.");
            self::redirectionVersURL();
        } else{
            if(!ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) && !ConnexionUtilisateur::estAdministrateur()) {
                MessageFlash::ajouter("danger","Formulaire restreint à l'utilisateur connecté.");
                self::redirectionVersURL("afficherListe",self::$controleur);
            } else{
                $id = $_REQUEST['id'];
                if(!ConnexionUtilisateur::estAdministrateur()){
                    $id = ConnexionUtilisateur::getIdUtilisateurConnecte();
                }
                self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'utilisateur/formulaireMiseAJour.php', 'id' => $id, 'controleur' => self::$controleur]);
            }
        }
    }

    public static function afficherFormulaireAvatar() : void{
        if(!isset( $_REQUEST['id'])){
            MessageFlash::ajouter("danger","Login non valide.");
            self::redirectionVersURL();
        } else{
            if(!ConnexionUtilisateur::estUtilisateur($_REQUEST['id']) && !ConnexionUtilisateur::estAdministrateur()) {
                MessageFlash::ajouter("danger","Formulaire restreint à l'utilisateur connecté.");
                self::redirectionVersURL("afficherListe",self::$controleur);
            } else{
                $id = $_REQUEST['id'];
                if(!ConnexionUtilisateur::estAdministrateur()){
                    $id = ConnexionUtilisateur::getIdUtilisateurConnecte();
                }
                self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'utilisateur/formulaireAvatar.php', 'id' => $id]);
            }
        }
    }

    public static function afficherFormulaireConnexion() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Connexion Utilisateur", "cheminCorpsVue" => 'utilisateur/formulaireConnexion.php']);
    }

    public static function connecter() : void{
        if (!isset($_REQUEST["id"]) || !isset($_REQUEST["mdp"])){
            MessageFlash::ajouter("danger","Login et/ou mot de passe manquant.");
            self::redirectionVersURL("afficherFormulaireConnexion",self::$controleur);
        } else{
            /** @var Utilisateur $utilisateur */
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST["id"]);
            if($utilisateur == null || !MotDePasse::verifier($_REQUEST["mdp"],$utilisateur->getMdpHache())){
                if($utilisateur == null){
                    MessageFlash::ajouter("warning","Login inconnu.");
                } else{
                    MessageFlash::ajouter("warning","Mot de passe incorrect.");
                }
                self::redirectionVersURL("afficherFormulaireConnexion",self::$controleur);
            } else{
                if(!VerificationEmail::aValideEmail($utilisateur)){
                    MessageFlash::ajouter("warning","Vous devez valider le mail !");
                    self::redirectionVersURL("afficherFormulaireConnexion",self::$controleur);
                }else {
                    ConnexionUtilisateur::connecter($utilisateur->getId());
                    MessageFlash::ajouter("success","Connexion avec succès !");
                    $idUrl = rawurlencode($_REQUEST['id']);
                    self::redirectionVersURL("afficherDetail&id=$idUrl",self::$controleur);
                }
            }
        }
    }

    public static function deconnecter(): void{
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success","Déconnexion !");
        self::redirectionVersURL("afficherListe",self::$controleur);
    }

    public static function creerDepuisFormulaire() : void{
        if($_REQUEST["mdp"] != $_REQUEST["mdp2"]){
            MessageFlash::ajouter("warning","Mots de passe distincts");
            self::redirectionVersURL("afficherFormulaireCreation",self::$controleur);
        } else{
            if(!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)){
                MessageFlash::ajouter("warning","Email incorrect");
                self::redirectionVersURL("afficherFormulaireCreation",self::$controleur);
            } else {
                if (!ConnexionUtilisateur::estAdministrateur()) {
                    unset($_REQUEST["estAdmin"]);
                    $utilisateur = self::construireDepuisFormulaire($_REQUEST);
                } else{
                    $utilisateur = self::construireDepuisFormulaireAdmin($_REQUEST);
                }

                (new UtilisateurRepository)->ajouter($utilisateur);
                MessageFlash::ajouter("success","Compte créé !");
                if(!ConnexionUtilisateur::estConnecte()){
                    ConnexionUtilisateur::connecter($utilisateur->getId());
                }
                $idUrl=rawurlencode($utilisateur->getId());
                self::redirectionVersURL("afficherDetail&id=$idUrl",self::$controleur);
            }
        }
    }

    public static function supprimer() : void {
        if (!isset($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Login non valide.");
            self::redirectionVersURL();
        } else {
            if (!ConnexionUtilisateur::estAdministrateur()) {
                MessageFlash::ajouter("danger","Vous n'êtes pas le bon utilisateur.");
                self::redirectionVersURL();
            } else {
                (new UtilisateurRepository())->supprimer($_REQUEST['id']);
                $idHtml = htmlspecialchars($_REQUEST['id']);
                MessageFlash::ajouter("success", "Compte $idHtml supprimé !");
                self::redirectionVersURL("afficherListe", self::$controleur);
            }
        }
    }

    public static function mettreAJour() : void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['nom']) || !isset($_REQUEST['prenom']) || !isset($_REQUEST['pseudo']) || !isset($_REQUEST['date']) || !isset($_REQUEST['amdp']) || !isset($_REQUEST['mdp']) || !isset($_REQUEST['mdp2'])){
            MessageFlash::ajouter("danger","Informations non complètes.");
            self::redirectionVersURL("afficherFormulaireMiseAJour",self::$controleur);
        } else {
            /** @var Utilisateur $utilPossible */
            $utilPossible = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['id']);
            if($utilPossible == null || ($utilPossible->getId() != ConnexionUtilisateur::getIdUtilisateurConnecte() && !ConnexionUtilisateur::estAdministrateur())){
                MessageFlash::ajouter("danger","Utilisateur non valide.");
                self::redirectionVersURL();
            } else {
                if($_REQUEST['mdp'] != $_REQUEST['mdp2']){
                    MessageFlash::ajouter("warning","Mots de passe distincts.");
                    self::redirectionVersURL("afficherFormulaireMiseAJour",self::$controleur);
                } else {
                    if(!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['amdp'],$utilPossible->getMdpHache())){
                        MessageFlash::ajouter("warning","Ancien mot de passe erroné.");
                        self::redirectionVersURL("afficherFormulaireMiseAJour",self::$controleur);
                    } else {
                        $boolMail = false;
                        if(isset($_REQUEST["email"]) && $_REQUEST["email"] != $utilPossible->getEmail()){
                            if(ConnexionUtilisateur::estAdministrateur()){
                                $utilPossible->setEmail($_REQUEST["email"]);
                                $utilPossible->setEmailAValider("");
                                $utilPossible->setNonce("");
                            }
                            else if(filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)){
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
                        MessageFlash::ajouter("success","Profil de $idHTML a été mis à jour !");
                        self::redirectionVersURL("afficherListe",self::$controleur);
                    }
                }
            }
        }
    }
    public static function mettreAJourAvatar():void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['mdp'])){
            MessageFlash::ajouter("danger","Informations non complètes.");
            self::redirectionVersURL();
        } else{
            if(!ConnexionUtilisateur::estAdministrateur() && !ConnexionUtilisateur::estUtilisateur($_REQUEST['id'])){
                MessageFlash::ajouter("danger","Utilisateur non valide.");
                self::redirectionVersURL();
            }else {
                $id = $_REQUEST['id'];
                $idUrl = rawurlencode($id);
                /** @var Utilisateur $utilisateur */
                $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
                if (!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['mdp'], $utilisateur->getMdpHache())) {
                    MessageFlash::ajouter("warning", "Mot de passe incorrect !");
                    self::redirectionVersURL("afficherFormulaireAvatar&id=$idUrl", self::$controleur);
                } else {
                    if (!(!empty($_FILES[$id]) && is_uploaded_file($_FILES[$id]['tmp_name']))) {
                        MessageFlash::ajouter("warning", "Problème avec le fichier.");
                        self::redirectionVersURL();
                    } else {
                        $allowed_ext = array("jpg", "png");
                        $explosion = explode(".", $_FILES[$id]['name']);
                        if(!in_array(end($explosion), $allowed_ext)){
                            MessageFlash::ajouter("warning","Les fichiers autorisés sont en .png et .jpg");
                            self::redirectionVersURL("afficherFormulaireAvatar&id=$idUrl", self::$controleur);
                        } else{
                            $pic_path = __DIR__ ."/../../ressources/img/uploads/pp_utilisateurs/$idUrl.".end($explosion);
                            if (!move_uploaded_file($_FILES[$id]['tmp_name'], $pic_path)) {
                                MessageFlash::ajouter("danger", "Problème d'export d'image, peut-être un problème venant de votre fichier.");
                                self::redirectionVersURL();
                            } else {
                                MessageFlash::ajouter("success", "Changement de votre photo de profil!");
                                self::redirectionVersURL("afficherDetail&id=$idUrl", self::$controleur);
                            }
                        }
                    }
                }
            }
        }
    }
    public static function validerEmail() : void{
        if(!isset($_REQUEST['id']) || !isset($_REQUEST['nonce'])){
            MessageFlash::ajouter("danger","Inexistant");
            self::redirectionVersURL();
        } else{
            if(!VerificationEmail::traiterEmailValidation($_REQUEST['id'], $_REQUEST['nonce'])){
                MessageFlash::ajouter("warning","Lien non valide!");
                self::redirectionVersURL("afficherListe",self::$controleur);
            } else{
                MessageFlash::ajouter("success","Email validé!");
                ConnexionUtilisateur::connecter($_REQUEST['id']);
                $idUrl = rawurlencode($_REQUEST['id']);
                self::redirectionVersURL("afficherDetail&id=$idUrl",self::$controleur);
            }
        }
    }

    /**
     * @return Utilisateur
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Utilisateur {
        $mdpHache = MotDePasse::hacher($tableauDonneesFormulaire['mdp']);
        $utilisateur = new Utilisateur($tableauDonneesFormulaire['id'], $tableauDonneesFormulaire['nom'], $tableauDonneesFormulaire['prenom'],$tableauDonneesFormulaire['pseudo'],"",$tableauDonneesFormulaire['email'],MotDePasse::genererChaineAleatoire(), new DateTime($tableauDonneesFormulaire['dateDeNaissance']), $mdpHache, isset($tableauDonneesFormulaire['estAdmin']));
        VerificationEmail::envoiEmailValidation($utilisateur);
        return $utilisateur;
    }
    private static function construireDepuisFormulaireAdmin(array $tableauDonneesFormulaire): Utilisateur {
        $mdpHache = MotDePasse::hacher($tableauDonneesFormulaire['mdp']);
        return new Utilisateur($tableauDonneesFormulaire['id'], $tableauDonneesFormulaire['nom'], $tableauDonneesFormulaire['prenom'],$tableauDonneesFormulaire['pseudo'],$tableauDonneesFormulaire['email'],"","", new DateTime($tableauDonneesFormulaire['dateDeNaissance']), $mdpHache, isset($tableauDonneesFormulaire['estAdmin']));
    }
}
?>