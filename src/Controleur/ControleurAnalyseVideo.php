<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Coaching;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\Repository\AnalyseVideoRepository;
use App\Covoiturage\Modele\Repository\CoachingRepository;

class ControleurAnalyseVideo extends ControleurService {

    private static string $controleur = "analyseVideo";

    public static function afficherFormulaireMiseAJour() : void{
        if(!isset( $_REQUEST['codeService'])){
            self::afficherErreur("Erreur, le services n'existe pas !");
        } else{
            $codeService = $_REQUEST['codeService'];
            self::afficherVue('vueGenerale.php', ["titre" => "Formulaire de MAJ", "cheminCorpsVue" => 'service/formulaireMiseAJourAnalyseVideo.php', 'codeService' => $codeService, 'controleur' => self::$controleur]);
        }
    }

    public static function supprimer() : void {
        if (!isset($_REQUEST['codeService'])) {
            self::afficherErreur("codeService inexistant !");
        } else {
            (new AnalyseVideoRepository())->supprimer($_REQUEST['codeService']);
            $services = (new AnalyseVideoRepository())->recuperer();
            self::afficherVue('vueGenerale.php', ["titre" => "Suppression analyse video", "cheminCorpsVue" => 'service/serviceSupprime.php','services' => $services, 'codeService' => $_REQUEST['codeService'], 'controleur' => self::$controleur]);
        }
    }

    /**
     * Permet a l'utilisateur de proposer un services (coaching / analyse vidéo)
     * @return void
     */
    public static function creerDepuisFormulaire(): void {
        try {
            $service = self::construireDepuisFormulaire($_REQUEST);

            (new AnalyseVideoRepository())->ajouter($service);

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
     * Construit un objet service en fonction du formulaire rempli par l'utilisateur.
     * @param array $tableauDonneesFormulaire
     * @return Services|null
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Services {

        $nomService = $tableauDonneesFormulaire['nom_services'];
        $descriptionService = $tableauDonneesFormulaire['description'];
        $nomJeu = $tableauDonneesFormulaire['jeu'];
        $prix = $tableauDonneesFormulaire['prix'];
        $coach = ConnexionUtilisateur::getIdUtilisateurConnecte();
        $nbJourRendu = $tableauDonneesFormulaire['nbJourRendu'];

        return new AnalyseVideo(
            null,
            $nomService,
            $descriptionService,
            $prix,
            $coach,
            $nomJeu,
            $nbJourRendu
        );

    }

}