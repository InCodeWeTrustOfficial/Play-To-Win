<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\AnalyseVideo;
use App\PlayToWin\Modele\DataObject\Coaching;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;

class ControleurCoaching extends ControleurService {

    protected static string $controleur = "coaching";

    public static function supprimer() : void {
        if (!isset($_REQUEST['codeService'])) {
            self::afficherErreur("codeService inexistant !");
        } else {
            (new CoachingRepository())->supprimer($_REQUEST['codeService']);
            $services = (new CoachingRepository())->recuperer();
            self::afficherVue('vueGenerale.php', ["titre" => "Suppression analyse video", "cheminCorpsVue" => 'service/serviceSupprime.php','services' => $services, 'codeService' => $_REQUEST['codeService'], 'controleur' => self::$controleur]);
        }
    }

    public static function mettreAJour(): void {

        $codeService = $_REQUEST['codeService'];
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

        $repository->mettreAJour($service);

        $services = (new CoachingRepository())->recuperer();

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

            (new CoachingRepository())->ajouter($service);

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
        $duree = $tableauDonneesFormulaire['duree'];

        return new Coaching (
            null,
            $nomService,
            $descriptionService,
            $prix,
            $coach,
            $nomJeu,
            $duree
        );
    }

    public static function getControleur(): string {
        return self::$controleur;
    }

}