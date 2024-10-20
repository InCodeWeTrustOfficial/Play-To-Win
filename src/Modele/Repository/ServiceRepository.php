<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Utilisateur;

class ServiceRepository extends AbstractRepository{

    protected function getNomTable(): string
    {
        return "p_Services";
    }
    protected function getNomClePrimaire(): string {
        return "codeService	";
    }
    protected function getNomsColonnes(): array {
        return ["codeService", "nomService", "descriptionService", "prixService", "idUtilisateur","nomJeu"];
    }

    protected function formatTableauSQL(AbstractDataObject $utilisateur): array
    {
        /** @var Utilisateur $utilisateur */
        return array(
            ":loginTag" => $utilisateur->getLogin(),
            ":nomTag" => $utilisateur->getNom(),
            ":prenomTag" => $utilisateur->getPrenom(),
            ":mdpHacheTag" => $utilisateur->getMdpHache(),
            ":estAdminTag" => $utilisateur->isAdmin()?1:0,
            ":emailTag" => $utilisateur->getEmail(),
            ":emailAValiderTag" => $utilisateur->getEmailAValider(),
            ":nonceTag" => $utilisateur->getNonce()
        );
    }

    public function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur {
        return new Utilisateur($utilisateurFormatTableau[0], $utilisateurFormatTableau[1], $utilisateurFormatTableau[2], $utilisateurFormatTableau[3], $utilisateurFormatTableau[4], $utilisateurFormatTableau[5], $utilisateurFormatTableau[6], $utilisateurFormatTableau[7]);
    }

}