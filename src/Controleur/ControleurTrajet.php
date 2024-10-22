<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use DateTime;

class ControleurTrajet extends ControleurGenerique
{

    private static string $controleur = "trajet";

    public static function afficherListe() : void {
        $trajets = (new TrajetRepository)->recuperer();
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "trajet/liste.php", 'trajets'=>$trajets, 'controleur'=>self::$controleur]);
    }

    public static function afficherDetail() : void {

        if(!isset( $_REQUEST['id'])){
            self::afficherErreur();
        }else{
            $id = $_REQUEST['id'];
            $trajet = (new TrajetRepository())->recupererParClePrimaire($id);
            if($trajet != NULL) {
                self::afficherVue('vueGenerale.php',["titre" => "Détail des trajets", "cheminCorpsVue" => "trajet/detail.php", 'trajet'=>$trajet,'controleur'=>self::$controleur]);
            } else{
                $idHTML = htmlspecialchars($id);
                self::afficherErreur($idHTML);
            }
        }
    }

    public static function afficherFormulaireCreation() : void{
        self::afficherVue('vueGenerale.php',["titre" => "Formulaire création trajet", "cheminCorpsVue" => 'trajet/formulaireCreation.php','controleur'=>self::$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void{
        if(!isset( $_REQUEST['id'])){
            self::afficherErreur("Erreur, le trajet n'existe pas !");
        } else{
            $id = $_REQUEST['id'];
            self::afficherVue('vueGenerale.php', ["titre"=>"Formulaire de MAJ", "cheminCorpsVue" => 'trajet/formulaireMiseAJourAnalysevideo.php', 'id'=>$id,'controleur'=>self::$controleur]);
        }
    }

    public static function creerDepuisFormulaire() : void{

        $trajet = self::construireDepuisFormulaire($_REQUEST);
        (new TrajetRepository())->ajouter($trajet);

        $trajets = (new TrajetRepository)->recuperer();
        self::afficherVue('vueGenerale.php', ["titre" => "Création trajet", "cheminCorpsVue" => 'trajet/trajetCree.php', 'trajets'=>$trajets,'controleur'=>self::$controleur]);
    }

    public static function supprimer() : void{
        if(isset($_REQUEST['id'])){
            (new TrajetRepository())->supprimer($_REQUEST['id']);
            $trajets = (new TrajetRepository())->recuperer();
            $idHTML = htmlspecialchars($_REQUEST['id']);
            self::afficherVue('vueGenerale.php', ["titre" => "Suppression trajet", "cheminCorpsVue" => 'trajet/trajetSupprime.php', 'trajets'=>$trajets, 'id'=>$idHTML,'controleur'=>self::$controleur]);
        } else{
            self::afficherErreur("Erreur, le trajet n'existe pas !");
        }
    }

    public static function afficherErreur(string $messageErreur = ""): void {
        if(!$messageErreur == ""){
            $messageErreur = ': '.$messageErreur;
        }
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec l'utilisateur", "cheminCorpsVue" => "trajet/erreur.php", "messageErreur" => $messageErreur,'controleur'=>self::$controleur]);
    }

    public static function mettreAJour() : void{
        if(!isset($_REQUEST['depart']) || !isset($_REQUEST['arrivee']) || !isset($_REQUEST['date']) || !isset($_REQUEST['prix']) || !isset($_REQUEST['conducteurLogin'])){
            self::afficherErreur("Erreur, les informations ne sont pas complètes !");
        } else {
            $trajet = self::construireDepuisFormulaire($_REQUEST);
            (new TrajetRepository())->mettreAJour($trajet);
            $idHTML = htmlspecialchars($_REQUEST['id']);
            $trajets = (new TrajetRepository())->recuperer();
            self::afficherVue('vueGenerale.php', ["titre" => "Modification trajet", "cheminCorpsVue" => 'trajet/trajetMisAJour.php', 'id'=>$idHTML, 'trajets'=>$trajets,'controleur'=>self::$controleur]);
        }
    }

    /**
     * @return Trajet
     * @throws \Exception
     */
    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Trajet {
        $trajet = new Trajet(
            $tableauDonneesFormulaire['id']??null,
            $tableauDonneesFormulaire['depart'],
            $tableauDonneesFormulaire['arrivee'],
            new DateTime($tableauDonneesFormulaire['date']),
            $tableauDonneesFormulaire['prix'],
            (new UtilisateurRepository())->recupererParClePrimaire($tableauDonneesFormulaire['conducteurLogin']),
            isset($tableauDonneesFormulaire["nonFumeur"])
        );
        return $trajet;
    }
}