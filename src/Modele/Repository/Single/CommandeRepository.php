<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Commande;
use DateTime;

class CommandeRepository extends AbstractRepository {

    public function getNomTable(): string {
        return "p_Commandes";
    }
    public function getNomClePrimaire(): string {
        return "idCommande";
    }
    public function getNomsColonnes(): array {
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
        $dateAchat = new DateTime($servicesFormatTableau[1]);

        return new Commande(
            $servicesFormatTableau[0], // idCommande
            $dateAchat,                 // DateTime object
            $servicesFormatTableau[2]   // idUtilisateur
        );
    }
}