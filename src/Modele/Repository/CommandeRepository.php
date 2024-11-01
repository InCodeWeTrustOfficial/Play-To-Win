<?php

namespace App\PlayToWin\Modele\Repository;

use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Commande;
use DateTime;

class CommandeRepository extends AbstractRepository{

    protected function getNomTable(): string {
        return "p_Commandes";
    }
    protected function getNomClePrimaire(): string {
        return "idCommande";
    }
    protected function getNomsColonnes(): array {
        return ["idCommande", "dateAchatCommande", "idUtilisateur"];
    }

    protected function formatTableauSQL(AbstractDataObject $commandes): array {
        /** @var Commande $commandes */
        return array(
            ":idCommandeTag" => $commandes->getIdCommande(),
            ":dateAchatCommandeTag" => $commandes->getDateAchat()->format('Y-m-d H:i:s'),
            ":idUtilisateurTag" => $commandes->getIdUtilisateur(),
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Commande {
        return new Commande (
            $servicesFormatTableau[0], $servicesFormatTableau[1], $servicesFormatTableau[2]
        );
    }
}