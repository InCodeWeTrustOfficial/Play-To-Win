<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\AnalyseVideoRepository;
use App\Covoiturage\Modele\Repository\CoachingRepository;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Coaching;

class ControleurService extends ControleurGenerique {

    private static string $controleur = "service";

    public static function afficherListe() : void {
        //$services = array_merge((new AnalyseVideoRepository())->recuperer(),(new CoachingRepository())->recuperer()) ;
        $services = (new AnalyseVideoRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des services", "cheminCorpsVue" => "service/liste.php", 'services'=>$services, 'controleur'=>self::$controleur]);
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

    public static function mettreAJour(): void {
        if (!isset($_REQUEST['nom_services']) || !isset($_REQUEST['description']) ||
            !isset($_REQUEST['jeu']) || !isset($_REQUEST['type']) || !isset($_REQUEST['prix'])) {
            self::afficherErreur("Erreur, les informations ne sont pas complètes !");
            return;
        }

        $codeService = $_REQUEST['codeService'];

        if ($_REQUEST['type'] === "Analyse vidéo") {
            $repository = new AnalyseVideoRepository();
            $service = $repository->recupererParClePrimaire($codeService);

            if ($service === null) {
                self::afficherErreur("Service non trouvé !");
                return;
            }

            $service->setNomService($_REQUEST['nom_services']);
            $service->setDescriptionService($_REQUEST['description']);
            $service->setNomJeu($_REQUEST['jeu']);
            $service->setPrixService((float) $_REQUEST['prix']);
            $service->setNbJourRendu((int) $_REQUEST['nbJourRendu']);

        } else if ($_REQUEST['type'] === "Coaching") {
            $repository = new CoachingRepository();
            $service = $repository->recupererParClePrimaire($codeService);

            if ($service === null) {
                self::afficherErreur("Service non trouvé !");
                return;
            }

            $service->setNomService($_REQUEST['nom_services']);
            $service->setDescriptionService($_REQUEST['description']);
            $service->setNomJeu($_REQUEST['jeu']);
            $service->setPrixService((float) $_REQUEST['prix']);
            $service->setDuree((int) $_REQUEST['duree']);
        } else {
            self::afficherErreur("Type de service non valide !");
            return;
        }

        $repository->mettreAJour($service);

        $services = (new AnalyseVideoRepository())->recuperer();

        self::afficherVue('vueGenerale.php', [
            "titre" => "Service mis à jour",
            "cheminCorpsVue" => 'service/serviceMisAJour.php',
            'services' => $services,
            'controleur' => self::$controleur
        ]);
    }

}