<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Modele\Repository\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\CoachingRepository;

abstract class ControleurService extends ControleurGenerique {

    protected static string $controleur = 'service';

    public static function afficherListe() : void {
        $services = array_merge((new AnalyseVideoRepository())->recuperer(),(new CoachingRepository())->recuperer()) ;
        self::afficherVue('vueGenerale.php',["titre" => "Liste des services", "cheminCorpsVue" => "service/liste.php", 'services'=>$services, 'controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void{
        if(!isset( $_REQUEST['codeService'])){
            self::afficherErreur("Erreur, le services n'existe pas !");
        } else{
            $codeService = $_REQUEST['codeService'];
            self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'service/formulaireMiseAJour' . ucfirst(static::getControleur()) . '.php', 'codeService' => $codeService, 'controleur' => self::$controleur]);
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
                self::afficherVue('vueGenerale.php',["titre" => "Détail des utilisateurs", "cheminCorpsVue" => "service/detail" . ucfirst($service->getTypeService()) . ".php", 'service'=>$service,'controleur'=>self::$controleur]);
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

    abstract static function getControleur(): string ;

}