<?php
namespace App\PlayToWin\Controleur;
use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\LogistiqueImage;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\MotDePasse;
use App\PlayToWin\Lib\VerificationEmail;
use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Association\SeClasserRepository;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;
use App\PlayToWin\Modele\Repository\Single\LangueRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;
use DateTime;

class ControleurUtilisateur extends ControleurGenerique {

    private static string $controleur = "utilisateur";
    public static function afficherDetail() : void {

        if (self::existePasRequest(["id"], "L'utilistateur est inexistant !")) return;

        $id = $_REQUEST['id'];

        if (self::nestPasBonUtilisateur($id)) return;

        /** @var Utilisateur $utilisateur */

        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);

        $idURLL = rawurlencode($utilisateur->getId());
        $idHTML = htmlspecialchars($utilisateur->getId());
        $nomHTML = htmlspecialchars($utilisateur->getNom());
        $prenomHTML = htmlspecialchars($utilisateur->getPrenom());
        $pseudoHTML = htmlspecialchars($utilisateur->getPseudo());
        $dateNaissanceHTML = htmlspecialchars($utilisateur->getDateNaissance()->format("d/m/Y"));
        $emailHTML = htmlspecialchars($utilisateur->getEmail());
        $avatarHTML = htmlspecialchars($utilisateur->getAvatarPath());

        $langues = (new ParlerRepository())->recupererLangues($utilisateur->getId());
        $jouer = (new JouerRepository())->recupererModeJeuClassement($utilisateur->getId());

        $aValideEmail = $utilisateur->getEmail() !== "";
        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        $estBonUtilisateur = $estAdmin || (ConnexionUtilisateur::estConnecte() && ConnexionUtilisateur::estUtilisateur($utilisateur->getId()));
        $estCoachh = (new CoachRepository())->estCoach($id);

        $avatarPath =$utilisateur->getAvatarPath();
        $emailAValider = "";
        if(!$aValideEmail){
            $emailAValider = htmlspecialchars($utilisateur->getEmailAValider());
        }

        $jouerDetails = [];

        if (empty($jouer)) {
            $jouerDetails = null;
        } else {
            foreach ($jouer as $ligne){
                /** @var ClassementJeu $classJeu */
                $classJeu = (new SeClasserRepository())->recupererDepuisJouer($ligne);
                $modeHTML = htmlspecialchars($ligne[1]->getNomMode());
                $modeURL = rawurlencode($ligne[1]->getNomMode());
                $pathLogo = $ligne[0]->getPathLogo();
                $nomJeuHTML = htmlspecialchars($ligne[0]->getNomJeu());
                $classPath = $classJeu->getClassPath();
                $codeJeu = $ligne[0]->getCodeJeu();

                $jouerDetails[] = [
                    'modeHTML' => $modeHTML,
                    'modeURL' => $modeURL,
                    'pathLogo' => $pathLogo,
                    'nomJeuHTML' => $nomJeuHTML,
                    'classPath' => $classPath,
                    'codeJeu' => $codeJeu,
                ];
            }
        }

        self::afficherVue('vueGenerale.php', ["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "utilisateur/detail.php", 'utilisateur' => $utilisateur, 'controleur' => self::$controleur,
            "idURLL" => $idURLL, "idHTML" => $idHTML, "nomHTML" => $nomHTML, "prenomHTML" => $prenomHTML, "pseudoHTML" => $pseudoHTML,
            "dateNaissanceHTML" => $dateNaissanceHTML, "emailHTML" => $emailHTML, "avatarHTML" => $avatarHTML,
            "langues" => $langues, "jouer" => $jouer,
            "aValideEmail" => $aValideEmail, "estAdmin" => $estAdmin, "estBonUtilisateur" => $estBonUtilisateur, "estCoachh" => $estCoachh,
            "avatarPath" => $avatarPath, "emailAValider" => $emailAValider, "jouerDetails" => $jouerDetails]);

    }
    public static function afficherFormulaireCreation() : void{

        $action = "creerDepuisFormulaire";
        $titreFormulaire = "Création d'un nouvel utilisateur";


        $idHTML = null;
        $nomHTML = null;
        $prenomHTML = null;
        $pseudoHTML = null;
        $emailHTML = null;
        $dateYYYYMMJJ = null;


        $conf = ConfigurationSite::getDebug()?"get":"post";
        $estAdmin = ConnexionUtilisateur::estAdministrateur();

        self::afficherVue('vueGenerale.php',["titre" => "Formulaire création utilisateur",
            "cheminCorpsVue" => 'utilisateur/formulaireGenerique.php',
            'controleur'=>self::$controleur,
            "langues" => (new LangueRepository())->recuperer(),
            "conf" => $conf,
            "estAdmin" => $estAdmin, "estModif" => false, "action" => $action, "idHTML" => $idHTML, "utilAdmin" => false,
            "nomHTML" => $nomHTML, "prenomHTML" => $prenomHTML, "pseudoHTML" => $pseudoHTML, "dateYYYYMMJJ" => $dateYYYYMMJJ,
            "emailHTML" => $emailHTML, "titreFormulaire" => $titreFormulaire]);
    }

    public static function afficherFormulaireMiseAJour() : void{

        if (self::existePasRequest(["id"], "Login non valide.")) return;

        $id = $_REQUEST['id'];
        if (self::nestPasBonUtilisateur($id)) return;

        /**
        if (!ConnexionUtilisateur::estAdministrateur()) {
            $id = ConnexionUtilisateur::getIdUtilisateurConnecte();
        }
         * */
        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);

        $titreFormulaire = "Modification d'un utilisateur";

        $action = "mettreAJour";
        $langues = null;

        $conf = ConfigurationSite::getDebug()?"get":"post";


        $idHTML = htmlspecialchars($id);
        $nomHTML = htmlspecialchars($utilisateur->getNom());
        $prenomHTML = htmlspecialchars($utilisateur->getPrenom());
        $pseudoHTML = htmlspecialchars($utilisateur->getPseudo());
        $emailHTML = htmlspecialchars($utilisateur->getEmail());
        $dateYYYYMMJJ = htmlspecialchars($utilisateur->getDateNaissance()->format("Y-m-d"));

        $estAdmin = ConnexionUtilisateur::estAdministrateur();
        $utilAdmin = $utilisateur->isAdmin();

        self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'utilisateur/formulaireGenerique.php', 'id' => $id, 'controleur' => self::$controleur,
            "utilisateur" => $utilisateur, "conf" => $conf, "idHTML" => $idHTML, "nomHTML" => $nomHTML, "prenomHTML" => $prenomHTML,
            "pseudoHTML" => $pseudoHTML, "emailHTML" => $emailHTML, "dateYYYYMMJJ" => $dateYYYYMMJJ,"estAdmin" => $estAdmin, "utilAdmin" => $utilAdmin,
            "estModif" => true, "action" => $action, "langues" => $langues, "titreFormulaire" => $titreFormulaire]);


    }

    public static function afficherFormulaireAvatar() : void{

        if (self::existePasRequest(["id"], "Login non valide.")) return;
        $id = $_REQUEST['id'];
        if (self::nestPasBonUtilisateur($id)) return;

        if (!ConnexionUtilisateur::estAdministrateur()) {
            $id = ConnexionUtilisateur::getIdUtilisateurConnecte();
        }
        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
        $conf = ConfigurationSite::getDebug()?"get":"post";
        $avatarPath = $utilisateur->getAvatarPath();

        self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'utilisateur/formulaireAvatar.php', 'id' => $id,
            "utilisateur" => $utilisateur, "conf" => $conf, "avatarPath" => $avatarPath]);

    }

    public static function afficherFormulaireConnexion() : void{
        $conf = ConfigurationSite::getDebug()?"get":"post";
        self::afficherVue('vueGenerale.php',["titre" => "Connexion Utilisateur", "cheminCorpsVue" => 'utilisateur/formulaireConnexion.php',
            "conf" => $conf]);
    }

    public static function connecter(): void {

        if (self::existePasRequest(["id", "mdp"], "Login et/ou mot de passe manquant.", "afficherFormulaireConnexion", self::$controleur)) return;

        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST["id"]);
        if ($utilisateur == null || !MotDePasse::verifier($_REQUEST["mdp"], $utilisateur->getMdpHache())) {
            if ($utilisateur == null) {
                MessageFlash::ajouter("warning", "Login inconnu.");
            } else {
                MessageFlash::ajouter("warning", "Mot de passe incorrect.");
            }
            self::redirectionVersURL("afficherFormulaireConnexion", self::$controleur);
        } else {
            if (!VerificationEmail::aValideEmail($utilisateur)) {
                MessageFlash::ajouter("warning", "Vous devez valider le mail !");
                self::redirectionVersURL("afficherFormulaireConnexion", self::$controleur);
            } else {
                ConnexionUtilisateur::connecter($utilisateur->getId());
                MessageFlash::ajouter("success", "Connexion avec succès !");
                $idUrl = rawurlencode($_REQUEST['id']);
                self::redirectionVersURL("afficherDetail&id=$idUrl", self::$controleur);
            }
        }

    }

    public static function deconnecter(): void{
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter("success","Déconnexion !");
        self::redirectionVersURL();
    }

    public static function creerDepuisFormulaire() : void {

        if (self::existePasRequest(["id", "nom", "prenom", "pseudo", "date", "mdp", "mdp2", "lang", "email"], "Informations manquantes.")) return;

        $id = $_REQUEST['id'];

        $userDejaPresent = (new UtilisateurRepository())->recupererParClePrimaire($id);

        if($userDejaPresent != null){
            MessageFlash::ajouter("danger","L'utilisateur existe déjà");
            self::redirectionVersURL();
        } else{
            $nom = $_REQUEST['nom'];
            $prenom = $_REQUEST['prenom'];
            $pseudo = $_REQUEST['pseudo'];
            $email = $_REQUEST['email'];

            if (strlen($id) > 32 || strlen($nom) > 32 || strlen($prenom) > 32 || strlen($pseudo) > 32 || strlen($email) > 256) {
                MessageFlash::ajouter("danger", "Les données sont invalides");
                self::redirectionVersURL();
                return;
            }

            if ($_REQUEST["mdp"] != $_REQUEST["mdp2"]) {
                MessageFlash::ajouter("warning", "Mots de passe distincts");
                self::redirectionVersURL("afficherFormulaireCreation", self::$controleur);
            } else {
                if (!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                    MessageFlash::ajouter("warning", "Email incorrect");
                    self::redirectionVersURL("afficherFormulaireCreation", self::$controleur);
                } else {
                    if (!ConnexionUtilisateur::estAdministrateur()) {
                        unset($_REQUEST["estAdmin"]);
                        $utilisateur = self::construireDepuisFormulaire($_REQUEST);
                    } else {
                        $utilisateur = self::construireDepuisFormulaireAdmin($_REQUEST);
                    }
                    (new UtilisateurRepository)->ajouter($utilisateur);
                    (new ParlerRepository())->ajouterTuple(array($_REQUEST['id'], $_REQUEST["lang"]));
                    MessageFlash::ajouter("success", "Compte créé !");
                    if (!ConnexionUtilisateur::estConnecte()) {
                        ConnexionUtilisateur::connecter($utilisateur->getId());
                    }
                    $idUrl = rawurlencode($utilisateur->getId());
                    self::redirectionVersURL("afficherDetail&id=$idUrl", self::$controleur);
                }
            }
        }
    }

    public static function supprimer() : void {

        if (self::existePasRequest(["id"], "Login non valide.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository)->recupererParClePrimaire($id);

        (new LogistiqueImage($utilisateur->getPathAvatarBrut()))->supprimer(rawurlencode($id));

        if ($id === ConnexionUtilisateur::getIdUtilisateurConnecte()) {
            ConnexionUtilisateur::deconnecter();
        }

        (new UtilisateurRepository())->supprimer($_REQUEST['id']);
        $idHtml = htmlspecialchars($id);
        MessageFlash::ajouter("success", "Compte $idHtml supprimé !");
        self::redirectionVersURL();

    }

    public static function mettreAJour() : void{

        if (self::existePasRequest(["id", "nom", "prenom", "pseudo", "date", "amdp", "mdp", "mdp2"], "Informations non complètes.")) return;

        $id = $_REQUEST['id'];
        if (self::nestPasBonUtilisateur($id)) return;

        $idURL = rawurlencode($id);

        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $pseudo = $_REQUEST['pseudo'];
        $email = $_REQUEST['email'];

        if (strlen($id) > 32 || strlen($nom) > 32 || strlen($prenom) > 32 || strlen($pseudo) > 32 || strlen($email) > 256) {
            MessageFlash::ajouter("danger", "Les données sont invalides");
            self::redirectionVersURL();
            return;
        }

        /** @var Utilisateur $utilPossible */
        $utilPossible = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['id']);
        if ($utilPossible == null || ($utilPossible->getId() != ConnexionUtilisateur::getIdUtilisateurConnecte() && !ConnexionUtilisateur::estAdministrateur())) {
            MessageFlash::ajouter("danger", "Utilisateur non valide.");
            self::redirectionVersURL();
        } else {
            if ($_REQUEST['mdp'] != $_REQUEST['mdp2']) {
                MessageFlash::ajouter("warning", "Mots de passe distincts.");
                self::redirectionVersURL("afficherFormulaireMiseAJour&id=".$idURL, self::$controleur);
            } else {
                if (!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['amdp'], $utilPossible->getMdpHache())) {
                    MessageFlash::ajouter("warning", "Ancien mot de passe erroné.");
                    self::redirectionVersURL("afficherFormulaireMiseAJour&id=".$idURL, self::$controleur);
                } else {
                    $boolMail = false;
                    if (isset($_REQUEST["email"]) && $_REQUEST["email"] != $utilPossible->getEmail()) {
                        if (ConnexionUtilisateur::estAdministrateur()) {
                            $utilPossible->setEmail($_REQUEST["email"]);
                            $utilPossible->setEmailAValider("");
                            $utilPossible->setNonce("");
                        } else if (filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                            $boolMail = true;
                            $utilPossible->setEmailAValider($_REQUEST["email"]);
                            $utilPossible->setNonce(MotDePasse::genererChaineAleatoire());
                        }
                    }
                    $nomHtml = htmlspecialchars($nom);
                    $prenomHtml = htmlspecialchars($prenom);
                    $pseudoHtml = htmlspecialchars($pseudo);
                    $utilPossible->setNom($nomHtml);
                    $utilPossible->setPrenom($prenomHtml);
                    $utilPossible->setPseudo($pseudoHtml);
                    $utilPossible->setDateNaissance(new DateTime($_REQUEST['date']));
                    $utilPossible->setMdpHache(MotDePasse::hacher($_REQUEST['mdp']));
                    if (ConnexionUtilisateur::estAdministrateur()) {
                        $utilPossible->setAdmin(isset($_REQUEST['estAdmin']));
                    }
                    (new UtilisateurRepository())->mettreAJour($utilPossible);
                    if ($boolMail) {
                        VerificationEmail::envoiEmailValidation($utilPossible);
                    }
                    $idHTML = htmlspecialchars($id);
                    MessageFlash::ajouter("success", "Profil de $idHTML a été mis à jour !");
                    self::redirectionVersURL("afficherDetail&id=".$idURL,self::$controleur);
                }
            }

        }
    }
    public static function mettreAJourAvatar():void{

        if (self::existePasRequest(["id", "mdp"], "Informations non complètes.")) return;

        $id = $_REQUEST['id'];
        if (self::nestPasBonUtilisateur($id)) return;

        $idUrl = rawurlencode($id);
        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
        if (!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['mdp'], $utilisateur->getMdpHache())) {
            MessageFlash::ajouter("warning", "Mot de passe incorrect !");
            self::redirectionVersURL("afficherFormulaireAvatar&id=$idUrl", self::$controleur);
        } else {
            (new LogistiqueImage($utilisateur->getPathAvatarBrut()))->enregistrer(new ControleurUtilisateur(),$id, "afficherFormulaireAvatar", "utilisateur");
        }
    }

    public static function validerEmail(): void {

        if (self::existePasRequest(["id", "nonce"], "Ce lien est malheureusement invalide.")) return;

        if (!VerificationEmail::traiterEmailValidation($_REQUEST['id'], $_REQUEST['nonce'])) {
            MessageFlash::ajouter("warning", "Lien non valide!");
            self::redirectionVersURL();
        } else {
            MessageFlash::ajouter("success", "Email validé!");
            ConnexionUtilisateur::connecter($_REQUEST['id']);
            $idUrl = rawurlencode($_REQUEST['id']);
            self::redirectionVersURL("afficherDetail&id=$idUrl", self::$controleur);
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