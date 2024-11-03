<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Commande;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use DateTime;

class CommandeRepository extends AbstractRepository {

    public function getNomTable(): string {
        return "p_Commandes";
    }
    public function getNomClePrimaire(): string {
        return "idCommande";
    }
    public function getNomsColonnes(): array {
        return ["idCommande", "dateAchatCommande", "idUtilisateur", "prixTotal"];
    }

    protected function formatTableauSQL(AbstractDataObject $commandes): array {
        /** @var Commande $commandes */
        return array(
            ":idCommandeTag" => $commandes->getIdCommande(),
            ":dateAchatCommandeTag" => $commandes->getDateAchat()->format('Y-m-d H:i:s'),
            ":idUtilisateurTag" => $commandes->getIdUtilisateur(),
            ":prixTotalTag" => $commandes->getPrixTotal(),
        );
    }

    public function construireDepuisTableauSQL(array $servicesFormatTableau): Commande {
        try {
            return new Commande(
                $servicesFormatTableau[0],
                new DateTime(),
                $servicesFormatTableau[2],
                $servicesFormatTableau[3]
            );
        } catch (Exception $e) {
            throw new RuntimeException("Erreur lors de la conversion de la date : " . $e->getMessage());
        }
    }
}