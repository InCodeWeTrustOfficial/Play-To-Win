<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\Repository\AnalyseVideoRepository;
use App\Covoiturage\Modele\Repository\CoachingRepository;

class ControleurService extends ControleurGenerique {

    protected static string $controleur = 'service';

    public static function afficherListe() : void {
        //$services = array_merge((new AnalyseVideoRepository())->recuperer(),(new CoachingRepository())->recuperer()) ;
        $services = (new AnalyseVideoRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des services", "cheminCorpsVue" => "service/liste.php", 'services'=>$services, 'controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void{
        if(!isset( $_REQUEST['codeService'])){
            self::afficherErreur("Erreur, le services n'existe pas !");
        } else{
            $codeService = $_REQUEST['codeService'];
            self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'service/formulaireMiseAJour' . ucfirst(self::getControleur()) . '.php', 'codeService' => $codeService, 'controleur' => self::$controleur]);
        }
    }

    public static function afficherDetail() : void {
        if(!isset( $_REQUEST['codeService'])){
            self::afficherErreur("code services manquant");
        }else{

            $codeService = $_REQUEST['codeService'];
            $service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);

            if($service == NULL){
                $service = (new CoachingRepository())->recupererParClePrimaire($codeService);
            }

            if($service != NULL) {
                self::afficherVue('vueGenerale.php',["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "service/detail.php", 'service'=>$service,'controleur'=>self::$controleur]);
            } else{
                self::afficherErreur($codeService);
            }
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if(!$messageErreur == ""){
            $messageErreur = ': '.$messageErreur;
        }
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec le services", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur,'controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireProposerService() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Proposition services", "cheminCorpsVue" => 'service/formulaireCreation.php']);
    }

    public static function getControleur(): string {
        echo self::$controleur;
        return self::$controleur;
    }


}