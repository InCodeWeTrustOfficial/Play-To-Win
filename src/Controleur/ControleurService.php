<?php

namespace App\PlayToWin\Controleur;

use App\PlayToWin\Lib\GestionPanier;
use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Service;
use App\PlayToWin\Modele\HTTP\Session;
use App\PlayToWin\Modele\Repository\Single\AnalyseVideoRepository;
use App\PlayToWin\Modele\Repository\Single\CoachingRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\ServiceRepository;

abstract class ControleurService extends ControleurGenerique {

    protected static string $controleur = 'service';
    abstract static function supprimer();
    abstract static function mettreAJour();
    abstract static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Service;
    abstract static function creerDepuisFormulaire();
    abstract public static function afficherFormulaireMiseAJour();
    abstract public static function afficherDetail();
    abstract public static function afficherSelfListe();

    static function getControleur(): string {return static::$controleur;}

    public static function afficherListe() : void {
        if (self::existePasRequest(["id"], "Le coach n'existe pas.")) return;

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
    }

    public static function afficherSelfListeUtil(ServiceRepository $repo) : void {
        if (self::existePasRequest(["id"], "Le coach n'existe pas.")) return;

        $coachId = htmlspecialchars($_REQUEST['id']);
        $services = (new $repo())->recupererParCoach($coachId);

        self::afficherVue('vueGenerale.php',[
            "titre" => "Liste des services",
            "cheminCorpsVue" => "service/liste.php",
            'services' => $services,
            'id' => $coachId,
            'controleur' => static::$controleur
        ]);
    }

    public static function afficherFormulaireMiseAJourUtil(ServiceRepository $repo) : void {
        if (self::existePasRequest(["id"], "Le services n'existe pas.")) return;

            $codeService = $_REQUEST['id'];

            /** @var Service $service */
            $service = $repo->recupererParClePrimaire($codeService);
            $jeu =   (new JeuRepository())->recupererParClePrimaire($service->getCodeJeu());
            $jeux = (new JeuRepository())->recuperer();

            self::afficherVue('vueGenerale.php', [
                "titre" => "Formulaire de MAJ",
                "cheminCorpsVue" => 'service/formulaireMiseAJour.php',
                'id' => $codeService,
                'service' => $service,
                'serviceRepo' => $repo,
                'jeu' => $jeu,
                'jeux' => $jeux,
                'controleur' => static::$controleur]);

    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('vueGenerale.php', [
            "titre" => "Proposition services",
            "cheminCorpsVue" => 'service/formulaireCreation.php']);
    }

    public static function afficherDetailUtil(ServiceRepository $repo) : void {
        if (self::existePasRequest(["id"], "Le services n'existe pas.")) return;

            $codeService = $_REQUEST['id'];
            $service = (new $repo())->recupererParClePrimaire($codeService);

            if ($service != NULL) {
                self::afficherVue('vueGenerale.php', [
                    "titre" => "Détail du service",
                    "cheminCorpsVue" => "service/detailService.php",
                    'service' => $service,
                    'controleur' => static::$controleur
                ]);
        }
    }

    protected static function supprimerUtils(ServiceRepository $repo) : void {
        if (self::existePasRequest(["id"], "Login non valide.")) return;

            $repo->supprimer($_REQUEST['id']);
            $services = $repo->recuperer();

            MessageFlash::ajouter("success", "Service supprimer");

            self::afficherVue('vueGenerale.php', [
                "titre" => "Liste des services",
                "cheminCorpsVue" => "service/liste.php",
                'services' => $services,
                'codeService' => $_REQUEST['id'],
                'controleur' => static::getControleur()]);
    }

    protected static function mettreAJourUtil(ServiceRepository $repo): void {
        if (self::existePasRequest(["id"], "Le service n'existe pas.")) return;

        /** @var ServiceRepository $service */

        $codeService = $_REQUEST['id'];
        $service = (new $repo)->recupererParClePrimaire($codeService);

        $service->setNomService($_REQUEST['nom_services']);
        $service->setDescriptionService($_REQUEST['description']);
        $service->setCodeJeu($_REQUEST['jeu']);
        $service->setPrixService((float) $_REQUEST['prix']);
        $attributsEnfants = $service->getAttributsEnfants();
        $enfantData = [];
        foreach ($attributsEnfants as $attr) {
            if (isset($_REQUEST[$attr])) {
                $enfantData[$attr] = $_REQUEST[$attr];
            }
        }

        $service->setAttributsEnfant($enfantData);

        (new $repo)->mettreAJour($service);

        $idUrl = rawurlencode($_REQUEST['idCoach']);

        MessageFlash::ajouter("success","Service mis à jour");
        self::redirectionVersURL("afficherListe&id=" . $idUrl ,self::$controleur);
    }

    protected static function creerDepuisFormulaireUtil(ServiceRepository $repo): void {
            if (self::existePasRequest(["id", "nom_services_id", "description_id", "jeu_id", "type_id", "prix_id"], "Informations manquantes.")) return;

            $service = static::construireDepuisFormulaire($_REQUEST);
            (new $repo())->ajouter($service);

            MessageFlash::ajouter("success", "Service ajouté");

            $services = $repo->recuperer();

            self::afficherVue('vueGenerale.php', [
                "titre" => "Liste des services",
                "cheminCorpsVue" => "service/liste.php",
                'services' => $services,
                'controleur' => static::getControleur()]);
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if (!$messageErreur == "") {
            $messageErreur = ': ' . $messageErreur;
        }
        MessageFlash::ajouter("danger", "Une erreur est survenue : ".htmlspecialchars($messageErreur));
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
        static::redirectionVersURL("afficherListe", 'coach');
    }

    public static function modifierQuantite(): void {
        GestionPanier::modifierQuantite();
        static::redirectionVersURL("afficherPanier", self::$controleur);
    }

    public static function supprimerProduit(): void {
        GestionPanier::supprimerProduit();
        static::redirectionVersURL("afficherPanier", self::$controleur);
    }

}
