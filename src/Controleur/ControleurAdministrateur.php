<?php

namespace App\PlayToWin\Controleur;
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Lib\MotDePasse;
use App\PlayToWin\Lib\VerificationEmail;
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Association\JouerRepository;
use App\PlayToWin\Modele\Repository\Association\ParlerRepository;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\LangueRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;
use DateTime;

class ControleurAdministrateur extends ControleurGenerique {

    private static string $controleur = "administrateur";

    public static function afficherListeUtilisateurs(): void {
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        $objetType = "utilisateur";
        self::afficherVue('vueGenerale.php', ["titre" => "Liste des utilisateurs",
            "cheminCorpsVue" => "utilisateur/liste.php",
            'utilisateurs' => $utilisateurs,
            'objetType' => $objetType,
            'controleur' => self::$controleur]);
    }

    public static function afficherListeServices(): void {
        $services = array_merge((new AnalyseVideoRepository())->recuperer(), (new CoachingRepository())->recuperer());

        $objetType = "service";
        self::afficherVue('vueGenerale.php', [
            "titre" => "Liste des services",
            "cheminCorpsVue" => "administrateur/liste.php",
            'objets' => $services,
            'objetType' => $objetType,
            'controleur' => self::$controleur]);
    }

    public static function afficherListeAnalyse() : void {
        $services = (new AnalyseVideoRepository())->recuperer();

        $objetType = "analysevideo";
        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "administrateur/liste.php",
            'objets' => $services,
            'objetType' => $objetType,
            'controleur' => self::$controleur
        ]);
    }

    public static function afficherListeCoaching() : void {
        $services = (new CoachingRepository())->recuperer();

        $objetType = "coaching";
        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "administrateur/liste.php",
            'objets' => $services,
            'objetType' => $objetType,
            'controleur' => self::$controleur
        ]);
    }

    public static function afficherListeCoachs(): void {
        $objetType = "coach";
        if(!isset($_REQUEST['jeu']) || $_REQUEST['jeu'] === 'rien'){
            $utilisateurs = (new CoachRepository())->recuperer();
        } else{
            /** @var Jeu $jeu */
            $jeu = (new JeuRepository())->recupererParClePrimaire($_REQUEST['jeu']);
            if($jeu === null){

                $utilisateurs = (new CoachRepository())->recuperer();
            } else{
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
        if(isset($_REQUEST['lang']) && $_REQUEST['lang'] !== 'rien'){
            /** @var Coach $utilisateur */
            $users = [];
            foreach($utilisateurs as $utilisateur){
                if((new ParlerRepository())->existeTuple([$utilisateur->getId(),$_REQUEST['lang']])){
                    $users[] = $utilisateur;
                }
            }
            $utilisateurs = $users;
        }

        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs",
            "cheminCorpsVue" => "administrateur/liste.php",
            'objets'=>$utilisateurs,
            'objetType' => $objetType,
            'controleur'=>self::$controleur]);
    }

}