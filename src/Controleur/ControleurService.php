<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\GestionPanier;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\ServiceRepository;

abstract class ControleurService extends ControleurGenerique {

    protected static string $controleur = 'service';
    abstract function supprimer();
    abstract function mettreAJour();
    abstract function construireDepuisFormulaire(array $tableauDonneesFormulaire): Services;
    abstract public static function afficherFormulaireMiseAJour();

    static function getControleur(): string {return static::$controleur;}

    public static function afficherListe() : void {
        if (isset($_REQUEST['id'])) {
            $coachId = $_REQUEST['id'];
            $services = array_merge(
                (new AnalyseVideoRepository())->recupererParCoach($coachId),
                (new CoachingRepository())->recupererParCoach($coachId)
            );
            self::afficherVue('vueGenerale.php', [
                "titre" => "Liste des services",
                "cheminCorpsVue" => "service/liste.php",
                'services' => $services,
                'id' => $coachId,
                'controleur' => self::$controleur
            ]);
        } else {
            MessageFlash::ajouter("danger", "Erreur, le coach n'existe pas !");
        }
    }

    public static function afficherListeAnalyse() : void {
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Erreur: ID du coach manquant ou vide!");
            self::redirectionVersURL("afficherListe", "coach");
            return;
        }

        $coachId = htmlspecialchars($_REQUEST['id']);
        $services = (new AnalyseVideoRepository())->recupererParCoach($coachId);

        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "service/liste.php",
            'services' => $services,
            'id' => $coachId,
            'controleur' => self::$controleur
        ]);
    }

    public static function afficherListeCoaching() : void {
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Erreur: ID du coach manquant ou vide!");
            self::redirectionVersURL("afficherListe", "coach");
            return;
        }

        $coachId = htmlspecialchars($_REQUEST['id']);
        $services = (new CoachingRepository())->recupererParCoach($coachId);

        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "service/liste.php",
            'services' => $services,
            'id' => $coachId,
            'controleur' => self::$controleur
        ]);
    }

    public static function afficherFormulaireMiseAJourUtil(ServiceRepository $repo) : void {
        if (!isset($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Erreur, le service n'existe pas !");
            self::afficherErreur("Erreur, le service n'existe pas !");
        } else {
            $codeService = $_REQUEST['id'];
            self::afficherVue('vueGenerale.php', [
                "titre" => "Formulaire de MAJ",
                "cheminCorpsVue" => 'service/formulaireMiseAJour.php',
                'codeService' => $codeService,
                'serviceRepo' => $repo,
                'controleur' => static::$controleur]);
        }
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('vueGenerale.php', [
            "titre" => "Proposition services",
            "cheminCorpsVue" => 'service/formulaireCreation.php']);
    }

    public static function afficherDetail() : void {
        if (!isset($_REQUEST['id'])) {
            MessageFlash::ajouter("danger", "Code service manquant.");
            self::afficherErreur("Code service manquant.");
        } else {
            $codeService = $_REQUEST['id'];
            $service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);

            if ($service == NULL) {
                $service = (new CoachingRepository())->recupererParClePrimaire($codeService);
            }

            if ($service != NULL) {
                self::afficherVue('vueGenerale.php', [
                    "titre" => "Détail du service",
                    "cheminCorpsVue" => "service/detail" . ucfirst($service->getControleur()) . ".php",
                    'service' => $service,
                    'controleur' => self::$controleur]);
            } else {
                MessageFlash::ajouter("danger", "Service introuvable : $codeService.");
                self::afficherErreur($codeService);
            }
        }
    }

    protected static function supprimerUtils(ServiceRepository $repo) : void {
        if (!isset($_REQUEST['id'])) {
            self::afficherErreur("codeService inexistant !");
        } else {
            $repo->supprimer($_REQUEST['id']);
            $services = $repo->recuperer();
            self::afficherVue('vueGenerale.php', [
                "titre" => "Suppression ". $repo->getNomTableService(),
                "cheminCorpsVue" => 'service/serviceSupprime.php',
                'services' => $services,
                'codeService' => $_REQUEST['codeService'],
                'controleur' => static::getControleur()]);
        }
    }

    protected static function mettreAJourUtil(ServiceRepository $repo): void {

        $codeService = $_REQUEST['id'];
        $service = (new $repo)->recupererParClePrimaire($codeService);

        if ($service === null) {
            self::afficherErreur("Service non trouvé !");
            return;
        }

        $service->setNomService($_REQUEST['nom_services']);
        $service->setDescriptionService($_REQUEST['description']);
        $service->setCodeJeu($_REQUEST['jeu']);
        $service->setPrixService((float) $_REQUEST['prix']);
        $service->setAttributsEnfant($_REQUEST[$service->getAttributsEnfants()]);


        $repo->mettreAJour($service);

        $services = (new $repo)->recuperer();

        self::afficherVue('vueGenerale.php', [
            "titre" => "Service mis à jour",
            "cheminCorpsVue" => 'service/serviceMisAJour.php',
            'services' => $services,
            'controleur' => $service->getControleur()
        ]);
    }
    
    protected static function creerDepuisFormulaireUtil(ServiceRepository $repo): void {
        try {
            $service = static::construireDepuisFormulaire($_REQUEST);

            (new $repo())->ajouter($service);

            MessageFlash::ajouter("success", "Service ajouter");
            self::redirectionVersURL("afficherPanier", self::$controleur);

        } catch (\Exception $e) {
            self::afficherErreur("Une erreur est survenue lors de la création du service : " . $e->getMessage());
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : $messageErreur");
        self::afficherVue('vueGenerale.php', ["titre" => "Problème avec le service", "cheminCorpsVue" => "service/erreur.php", "messageErreur" => $messageErreur, 'controleur' => self::$controleur]);
    }

    public static function afficherPanier() : void {
        $panier = Session::getInstance()->lire('panier');
        self::afficherVue('vueGenerale.php',["titre" => "Panier", "cheminCorpsVue" => "service/panier.php",
            'panier' => $panier,
            'controleur'=> static::$controleur]);
    }

    public static function ajouterAuPanier() : void {
        GestionPanier::ajouterAuPanier();
        self::redirectionVersURL("afficherListe", 'coach');
    }

    public static function modifierQuantite(): void {
        GestionPanier::modifierQuantite();
        self::redirectionVersURL("afficherPanier", self::$controleur);
    }

    public static function supprimerProduit(): void {
        GestionPanier::supprimerProduit();
        self::redirectionVersURL("afficherPanier", self::$controleur);
    }

}
