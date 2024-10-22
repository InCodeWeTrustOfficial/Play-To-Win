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