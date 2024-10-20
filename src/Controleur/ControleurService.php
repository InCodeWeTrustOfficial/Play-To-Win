<?php

namespace App\Covoiturage\Controleur;

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
        $utilisateurs = (new UtilisateurRepository())->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "utilisateur/liste.php", 'utilisateurs'=>$utilisateurs, 'controleur'=>self::$controleur]);
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
            $services = $repository->recuperer();

            self::afficherVue('vueGenerale.php', [
                "titre" => "Création service",
                "cheminCorpsVue" => 'service/ServicesCree.php',
                'services' => $services,
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
        $coach = "";  // ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $typeService = $tableauDonneesFormulaire['type'];

        if ($typeService === "Analyse vidéo") {
            $date = $tableauDonneesFormulaire['date'];
            return new AnalyseVideo(
                $nomService,
                $descriptionService,
                $prix,
                $prix,
                $coach,
                $nomJeu,
                $date
            );
        } elseif ($typeService === "Coaching") {
            $duree = $tableauDonneesFormulaire['duree'];
            return new Coaching(
                $nomService,
                $descriptionService,
                $prix,
                $prix,
                $coach,
                $nomJeu,
                $duree
            );
        }

       return null;

    }
}