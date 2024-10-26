<?php

namespace App\PlayToWin\Modele\Repository;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\DataObject\ExemplaireAnalyse;
use App\PlayToWin\Modele\DataObject\Services;
use App\PlayToWin\Modele\DataObject\Utilisateur;

class CommandeRepository extends AbstractRepository{

    protected function getNomTable(): string {
        return "p_commandes";
    }
    protected function getNomClePrimaire(): string {
        return "idCommande";
    }
    protected function getNomsColonnes(): array {
        return ["idCommande", "dateAchat", "idUtilisateur"];
    }

    protected function formatTableauSQL(AbstractDataObject $commandes): array {
        /** @var Commande $commandes */
        return array(
            ":idCommandeTag " => $commandes->getIdCommande(),
            ":dateAchatTag" => $commandes->getDateAchat(),
            ":idUtilisateurTag" => $commandes->getIdUtilisateur(),
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Commande {
        return new Commande (
            $servicesFormatTableau["idCommande"],
            $servicesFormatTableau["dateAchat"],
            $servicesFormatTableau["idUtilisateur"]
        );
    }
}