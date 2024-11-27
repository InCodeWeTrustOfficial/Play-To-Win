<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\LogistiqueImage;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\MotDePasse;
use App\PlayToWin\Lib\VerificationEmail;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\LangueRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class ControleurCoach extends ControleurGenerique {

    private static string $controleur = "coach";

    public static function afficherListe() : void {
        $avoirLangue = null;
        $avoirJeu = null;

        $jeu = null;
        $codeJeu = null;
        $nomJeu = null;
        $jeuRequest = null;

        if(!isset($_REQUEST['jeu']) || $_REQUEST['jeu'] === 'rien'){
            $utilisateurs = (new CoachRepository())->recuperer();
        } else{
            /** @var Jeu $jeu */
            $jeuRequest = $_REQUEST['jeu'];
            $jeu = (new JeuRepository())->recupererParClePrimaire($jeuRequest);
            if($jeu === null){
                $utilisateurs = (new CoachRepository())->recuperer();
            } else{
                $avoirJeu = true;
                $codeJeu = $jeu->getCodeJeu();
                $nomJeu = htmlspecialchars($jeu->getNomJeu());
                $utilisateurs = array();
                $tabs = (new JouerRepository())->recupererJoueursAvecJeu($jeu->getCodeJeu());
                /** @var Utilisateur $tab */
                foreach($tabs as $tab){
                    if ((new CoachRepository())->estCoach($tab->getId())){
                        $coach = (new CoachRepository())->recupererParClePrimaire($tab->getId());
                        $utilisateurs[] = $coach;
                    }
                }
            }

        }

        $langue = null;
        $codeAlphaLanque = null;
        $nomLangue = null;
        $langueRequest = null;

        if(isset($_REQUEST['lang']) && $_REQUEST['lang'] !== 'rien'){
            $avoirLangue = true;
            /** @var Coach $utilisateur */
            $users = [];
            foreach($utilisateurs as $utilisateur){
                if((new ParlerRepository())->existeTuple([$utilisateur->getId(),$_REQUEST['lang']])){
                    $users[] = $utilisateur;
                }
            }
            $utilisateurs = $users;
            /** @var Langue $langue */
            $langue = (new LangueRepository())->recupererParClePrimaire($_REQUEST['lang']);
            $codeAlphaLanque = rawurlencode($langue->getCodeAlpha());
            $nomLangue = htmlspecialchars($langue->getNom());

            $langueRequest = $_REQUEST['lang'];
        }
        $conf = ConfigurationSite::getDebug()?"get":"post";



        $langues = (new LangueRepository())->recuperer();
        $jeux = (new JeuRepository())->recuperer();

        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "coach/liste.php", 'coachs'=>$utilisateurs, 'controleur'=>self::$controleur,
            "conf" => $conf, "avoirLangue" => $avoirLangue, "langue" => $langue, "codeAlphaLangue" => $codeAlphaLanque, "nomLangue" => $nomLangue,
            "langues" => $langues, "langueRequest" => $langueRequest, "avoirJeu" => $avoirJeu,
            "jeu" => $jeu, "codeJeu" => $codeJeu, "nomJeu" => $nomJeu, "jeux" => $jeux, "jeuRequest" => $jeuRequest]);
    }
    
    public static function afficherDetail() : void{

        if (self::existePasRequest(["id"], "Le coach n'existe pas.")) return;

        $id = $_REQUEST['id'];
        $idHtml = htmlspecialchars($id);
        if (!(new CoachRepository())->estCoach($id)) {
            MessageFlash::ajouter("warning", "$idHtml n'est pas un coach.");
            self::redirectionVersURL();
        } else {
            /** @var Coach $coach */
            $coach = (new CoachRepository())->recupererParClePrimaire($id);
            $idURL = rawurlencode($id);
            $idHTML = htmlspecialchars($id);
            $nomHTML = htmlspecialchars($coach->getNom());
            $prenomHTML = htmlspecialchars($coach->getPrenom());
            $pseudoHTML = htmlspecialchars($coach->getPseudo());
            $emailHTML = htmlspecialchars($coach->getEmail());
            $biographieHTML = htmlspecialchars($coach->getBiographie());
            $dateNaissanceHTML = htmlspecialchars($coach->getDateNaissance()->format("d/m/Y"));
            $avatarHTML = htmlspecialchars($coach->getAvatarPath());

            $bonUtilisateur = ConnexionUtilisateur::estBonUtilisateur($id);

            $langues = (new ParlerRepository())->recupererLangues($coach->getId());

            $bannierePath = $coach->getBannierePath();

            self::afficherVue("vueGenerale.php", ["titre" => "Informations Coach", "cheminCorpsVue" => "coach/detail.php", "coach" => $coach,
                "idURL" => $idURL, "idHTML" => $idHTML, "nomHTML" => $nomHTML, "prenomHTML" => $prenomHTML,
                "pseudoHTML" => $pseudoHTML, "emailHTML" => $emailHTML, "dateNaissanceHTML" => $dateNaissanceHTML,
                "biographieHTML" => $biographieHTML, "avatarHTML" => $avatarHTML, "bonUtilisateur" => $bonUtilisateur,
                "langues" => $langues, "bannierePath" => $bannierePath]);
        }

    }

    public static function afficherFormulaireCreation(): void{

        if (self::existePasRequest(["id"], "Aucun utilisateur.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        if ((new CoachRepository())->estCoach($id)) {
            $idHtml = htmlspecialchars($id);
            MessageFlash::ajouter("info", "Le coach $idHtml est déjà inscrit !");
        } else {
            /** @var Utilisateur $utilisateur */
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);

            if (!VerificationEmail::aValideEmail($utilisateur) && !ConnexionUtilisateur::estAdministrateur()) {
                MessageFlash::ajouter("info", "Un coach doit avoir validé son mail.");
                self::redirectionVersURL("afficherDetail", "utilisateur");
            } else {
                $conf = ConfigurationSite::getDebug()?"get":"post";
                $idUtilisateur = htmlspecialchars(rawurlencode($utilisateur->getId()));
                $pseudoUtilisateur = htmlspecialchars($utilisateur->getPseudo());
                self::afficherVue("vueGenerale.php", ["titre" => "Formulaire création coach", "cheminCorpsVue" => "coach/formulaireCreation.php", "utilisateur" => $utilisateur, "controleur" => self::$controleur,
                    "conf" => $conf, "idUtilisateur" => $idUtilisateur, "pseudoUtilisateur" => $pseudoUtilisateur]);
            }

        }
    }

    public static function afficherFormulaireMiseAJour():void{

        if (self::existePasRequest(["id"], "Login inexistant.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        $coachRepo = new CoachRepository();

        if (!$coachRepo->estCoach($id)) {
            $idUrl = rawurlencode($id);
            MessageFlash::ajouter("warning", "Vous n'êtes pas coach !");
            self::redirectionVersURL("afficherFormulaireCreation&id=" . $idUrl, self::$controleur);
        } else {
            $conf = ConfigurationSite::getDebug()?"get":"post";
            /** @var Coach $coach */
            $coach = (new CoachRepository())->recupererParClePrimaire($id);
            $idUtilisateur =  htmlspecialchars(rawurlencode($coach->getId()));
            $biographieCoach =htmlspecialchars($coach->getBiographie());
            self::afficherVue("vueGenerale.php", ["titre" => "Mise à jour du coach", "cheminCorpsVue" => "coach/formulaireMiseAJour.php",
                "conf" => $conf, "idUtilisateur" => $idUtilisateur, "biographieCoach" => $biographieCoach]);
        }
    }
    public static function afficherFormulaireBanniere() : void{

        if (self::existePasRequest(["id"], "Login non valide.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        if (!(new CoachRepository())->estCoach($id)) {
            $idUrl = rawurlencode($id);
            MessageFlash::ajouter("danger", "Vous n'êtes pas coach !");
            self::redirectionVersURL("afficherFormulaireCreation&id=" . $idUrl, self::$controleur);
        } else {
            if (!ConnexionUtilisateur::estAdministrateur()) {
                $id = ConnexionUtilisateur::getIdUtilisateurConnecte();
            }
            /** @var Coach $coach */
            $coach = (new CoachRepository())->recupererParClePrimaire($id);
            $conf = ConfigurationSite::getDebug()?"get":"post";
            $banniereCoach = $coach->getBannierePath();
            self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'coach/formulaireBanniere.php', 'id' => $id,
                "conf" => $conf, "banniereCoach" => $banniereCoach]);
        }


    }

    public static function creerDepuisFormulaire(): void {

        if (self::existePasRequest(["id", "pseudo", "biographie", "mdp"], "Il manque des informations.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);
        $idUrl = rawurlencode($id);
        if (!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['mdp'], $utilisateur->getMdpHache())) {
            MessageFlash::ajouter("warning", "Mot de passe incorect");
            self::redirectionVersURL("afficherFormulaireCreation&id=$idUrl", self::$controleur);
        } else {
            $coach = self::construireDepuisFormulaire($_REQUEST);
            (new CoachRepository())->ajouter($coach);
            $msg = (ConnexionUtilisateur::estAdministrateur())?"Enregistrement du nouveau coach":"Vous êtes dorénavant enregistré en tant que coach";
            MessageFlash::ajouter("success", htmlspecialchars($msg));
            self::redirectionVersURL("afficherDetail&id=$idUrl", self::$controleur);
        }

    }

    public static function mettreAJour():void{

        if (self::existePasRequest(["id", "biographie", "mdp"], "Il manque des informations.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        /** @var Coach $coach */
        $coach = (new CoachRepository())->recupererParClePrimaire($id);
        $idUrl = rawurlencode($id);
        if (ConnexionUtilisateur::estUtilisateur($id) && !MotDePasse::verifier($_REQUEST['mdp'], $coach->getMdpHache())) {
            MessageFlash::ajouter("warning", "Mot de passe incorrect.");
            self::redirectionVersURL("afficherFormulaireMiseAJour&id=$idUrl", self::$controleur);
        } else {
            $coach->setBiographie($_REQUEST['biographie']);
            (new CoachRepository())->mettreAJour($coach);
            MessageFlash::ajouter("success", "Informations mises à jour !");
            self::redirectionVersURL("afficherDetail&id=$idUrl", self::$controleur);
        }

    }

    public static function mettreAJourBanniere():void{

        if(self::existePasRequest(["id","mdp"], "Informations non complètes.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;
        $idUrl = rawurlencode($id);

        $coachRepo = new CoachRepository();
        if (!$coachRepo->estCoach($id)) {
            MessageFlash::ajouter("danger", "Vous n'êtes pas coach !");
            self::redirectionVersURL("afficherFormulaireCreation&id=" . $idUrl, self::$controleur);
        } else {
            /** @var Coach $coach */
            $coach = $coachRepo->recupererParClePrimaire($id);
            if (!ConnexionUtilisateur::estAdministrateur() && !MotDePasse::verifier($_REQUEST['mdp'], $coach->getMdpHache())) {
                MessageFlash::ajouter("warning", "Mot de passe incorrect !");
                self::redirectionVersURL("afficherFormulaireBanniere&id=$idUrl", self::$controleur);
            } else {
                (new LogistiqueImage($coach->getPathBannieresBrut()))->enregistrer(new ControleurCoach(),$id,"afficherFormulaireBanniere",self::$controleur);
            }
        }
    }

    public static function supprimer() : void {

        if (self::existePasRequest(["id"], "Login non valide.")) return;

        $id = $_REQUEST["id"];
        if (self::nestPasBonUtilisateur($id)) return;

        $idHtml = htmlspecialchars($id);
        $idUrl = rawurlencode($id);

        /** @var Coach $coach */
        $coach = (new CoachRepository())->recupererParClePrimaire($id);
        (new LogistiqueImage($coach->getPathBannieresBrut()))->supprimer($idUrl);

        (new CoachRepository())->supprimer($id);
        MessageFlash::ajouter("success", "$idHtml désinscrit des coachs !");
        self::redirectionVersURL("afficherDetail&id=$idUrl", "utilisateur");


    }

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Coach {
        return new Coach((new UtilisateurRepository())->recupererParClePrimaire($tableauDonneesFormulaire['id']), $tableauDonneesFormulaire['biographie']);
    }

}