<?php

namespace App\PlayToWin\Modele\Repository\Single;

use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\Langue;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use DateTime;
use PDOException;

class UtilisateurRepository extends AbstractRepository {

    protected function getNomTable(): string {
        return "p_Utilisateurs";
    }
    public function getNomClePrimaire(): string {
        return "idUtilisateur";
    }
    protected function getNomsColonnes(): array {
        return [$this->getNomClePrimaire(), "nom", "prenom", "pseudo", "email", "emailAValider","nonce","dateDeNaissance","mdpHache","estAdmin"];
    }

    protected function formatTableauSQL(AbstractDataObject $utilisateur): array {
        /** @var Utilisateur $utilisateur */
        return array(
            ":idTag" => $utilisateur->getId(),
            ":nomTag" => $utilisateur->getNom(),
            ":prenomTag" => $utilisateur->getPrenom(),
            ":pseudoTag" => $utilisateur->getPseudo(),
            ":emailTag" => $utilisateur->getEmail(),
            ":emailAValiderTag" => $utilisateur->getEmailAValider(),
            ":nonceTag" => $utilisateur->getNonce(),
            ":dateNaissTag" => $utilisateur->getDateNaissance()->format('Y-m-d'),
            ":mdpHacheTag" => $utilisateur->getMdpHache(),
            ":estAdminTag" => $utilisateur->isAdmin()?1:0,
        );
    }
    public function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur {
        return new Utilisateur($utilisateurFormatTableau[0], $utilisateurFormatTableau[1], $utilisateurFormatTableau[2], $utilisateurFormatTableau[3], $utilisateurFormatTableau[4], $utilisateurFormatTableau[5], $utilisateurFormatTableau[6], new DateTime($utilisateurFormatTableau[7]), $utilisateurFormatTableau[8], $utilisateurFormatTableau[9]?1:0);
    }
    public function ajouterLangue(Langue $langue):void{

    }
}