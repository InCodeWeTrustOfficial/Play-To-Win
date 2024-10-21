<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\AnalyseVideoRepository;
use App\Covoiturage\Modele\Repository\CoachingRepository;
use App\Covoiturage\Modele\Repository\ServiceRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Coaching;

class ControleurService extends ControleurGenerique {

    private static string $controleur = "service";

    public static function afficherListe() : void {
        $services = (new AnalyseVideoRepository())->recuperer();

        foreach ($services as $service) {
            echo $service->getCodeService();
        }

        //$services = $services + (new CoachingRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des services", "cheminCorpsVue" => "service/liste.php", 'services'=>$services, 'controleur'=>self::$controleur]);
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
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec le services", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur,'controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireProposerService() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Proposition services", "cheminCorpsVue" => 'service/formulaireCreation.php']);
    }

    /**
     * Permet a l'utilisateur de proposer un services (coaching / analyse vidéo)
     * @return void
     */
    public static function creerDepuisFormulaire(): void {
        try {
            $service = self::construireDepuisFormulaire($_REQUEST);

            if ($_REQUEST['type'] === "Analyse vidéo") {
                $repository = new AnalyseVideoRepository();
            } else {
                $repository = new CoachingRepository();
            }

            $repository->ajouter($service);

            self::afficherVue('vueGenerale.php', [
                "titre" => "Création service",
                "cheminCorpsVue" => 'service/ServicesCree.php',
                'controleur' => self::$controleur
            ]);

        } catch (\Exception $e) {
            self::afficherErreur("Une erreur est survenue lors de la création du service : " . $e->getMessage());
        }
    }

    /**
     * @return Services
     */
    /**
     * Construit un objet service en fonction du formulaire rempli par l'utilisateur.
     * @param array $tableauDonneesFormulaire
     * @return Services|null
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): ?Services {
        $nomService = $tableauDonneesFormulaire['nom_services'];
        $descriptionService = $tableauDonneesFormulaire['description'];
        $nomJeu = $tableauDonneesFormulaire['jeu'];
        $prix = $tableauDonneesFormulaire['prix'];
        $coach = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $typeService = $tableauDonneesFormulaire['type'];

        if ($typeService === "Analyse vidéo") {
            $nbJourRendu = (int) $tableauDonneesFormulaire['nbJourRendu'];
            return new AnalyseVideo(
                $nomService,
                $descriptionService,
                $prix,
                $coach,
                $nomJeu,
                $nbJourRendu
            );
        } elseif ($typeService === "Coaching") {
            $duree = (int) $tableauDonneesFormulaire['duree'];
            return new Coaching(
                $nomService,
                $descriptionService,
                $prix,
                $coach,
                $nomJeu,
                $duree
            );
        }

        return null;
    }


}