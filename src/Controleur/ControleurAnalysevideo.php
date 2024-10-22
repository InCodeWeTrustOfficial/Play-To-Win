<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\ConnexionUtilisateur;
use App\Covoiturage\Modele\DataObject\AnalyseVideo;
use App\Covoiturage\Modele\DataObject\Services;
use App\Covoiturage\Modele\Repository\AnalyseVideoRepository;

class ControleurAnalysevideo extends ControleurService {

    protected static string $controleur = "analysevideo";

    public static function supprimer() : void {
        if (!isset($_REQUEST['codeService'])) {
            self::afficherErreur("codeService inexistant !");
        } else {
            (new AnalyseVideoRepository())->supprimer($_REQUEST['codeService']);
            $services = (new AnalyseVideoRepository())->recuperer();
            self::afficherVue('vueGenerale.php', ["titre" => "Suppression analyse video", "cheminCorpsVue" => 'service/serviceSupprime.php','services' => $services, 'codeService' => $_REQUEST['codeService'], 'controleur' => self::$controleur]);
        }
    }

    public static function mettreAJour(): void {

        $codeService = $_REQUEST['codeService'];
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

        $repository->mettreAJour($service);

        $services = (new AnalyseVideoRepository())->recuperer();

        self::afficherVue('vueGenerale.php', [
            "titre" => "Service mis à jour",
            "cheminCorpsVue" => 'service/serviceMisAJour.php',
            'services' => $services,
            'controleur' => 'analyseVideo'
        ]);
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

    public static function getControleur(): string {
        echo self::$controleur;
        return self::$controleur;
    }

}