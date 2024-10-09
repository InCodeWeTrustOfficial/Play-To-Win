<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use DateTime;

class ControleurTrajet
{

    private static function afficherVue(string $cheminVue, array $parametres = []) : void{
        extract($parametres);
        require __DIR__ . "/../vue/$cheminVue";
    }

    public static function afficherListe() : void {
        $trajets = (new TrajetRepository)->recuperer();
        $controleur = "trajet";
        self::afficherVue('vueGenerale.php',["titre" => "Liste des utilisateurs", "cheminCorpsVue" => "trajet/liste.php", 'trajets'=>$trajets, 'controleur'=>$controleur]);
    }

    public static function afficherDetail() : void {

        if(!isset( $_GET['id'])){
            self::afficherErreur();
        }else{
            $id = $_GET['id'];
            $trajet = (new TrajetRepository())->recupererParClePrimaire($id);
            if($trajet != NULL) {
                $controleur = "trajet";
                self::afficherVue('vueGenerale.php',["titre" => "Détail des trajets", "cheminCorpsVue" => "trajet/detail.php", 'trajet'=>$trajet,'controleur'=>$controleur]);
            } else{
                $idHTML = htmlspecialchars($id);
                self::afficherErreur($idHTML);
            }
        }
    }

    public static function afficherFormulaireCreation() : void{
        $controleur = "trajet";
        self::afficherVue('vueGenerale.php',["titre" => "Formulaire création trajet", "cheminCorpsVue" => 'trajet/formulaireCreation.php','controleur'=>$controleur]);
    }

    public static function afficherFormulaireMiseAJour() : void{
        $controleur = "trajet";
        if(!isset( $_GET['id'])){
            self::afficherErreur("Erreur, le trajet n'existe pas !");
        } else{
            $id = $_GET['id'];
            self::afficherVue('vueGenerale.php', ["titre"=>"Formulaire de MAJ", "cheminCorpsVue" => 'trajet/formulaireMiseAJour.php', 'id'=>$id,'controleur'=>$controleur]);
        }
    }

    public static function creerDepuisFormulaire() : void{

        $controleur = "trajet";

        $trajet = new Trajet(
            null,
            $_GET['depart'],
            $_GET['arrivee'],
            new DateTime($_GET['date']),
            $_GET['prix'],
            (new UtilisateurRepository())->recupererParClePrimaire($_GET['conducteurLogin']),
            isset($_GET["nonFumeur"])
        );
        (new TrajetRepository())->ajouter($trajet);

        $trajets = (new TrajetRepository)->recuperer();
        self::afficherVue('vueGenerale.php', ["titre" => "Création trajet", "cheminCorpsVue" => 'trajet/trajetCree.php', 'trajets'=>$trajets,'controleur'=>$controleur]);
    }

    public static function supprimer() : void{
        $controleur = "trajet";
        if(isset($_GET['id'])){
            (new TrajetRepository())->supprimer($_GET['id']);
            $trajets = (new TrajetRepository())->recuperer();
            $idHTML = htmlspecialchars($_GET['id']);
            self::afficherVue('vueGenerale.php', ["titre" => "Suppression trajet", "cheminCorpsVue" => 'trajet/trajetSupprime.php', 'trajets'=>$trajets, 'id'=>$idHTML,'controleur'=>$controleur]);
        } else{
            self::afficherErreur("Erreur, le trajet n'existe pas !");
        }
    }


    public static function afficherErreur(string $messageErreur = ""): void {
        $controleur = "trajet";
        if(!$messageErreur == ""){
            $messageErreur = ': '.$messageErreur;
        }
        self::afficherVue('vueGenerale.php',["titre" => "Problème avec l'utilisateur", "cheminCorpsVue" => "trajet/erreur.php", "messageErreur" => $messageErreur,'controleur'=>$controleur]);
    }
}