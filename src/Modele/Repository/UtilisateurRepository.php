<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use PDOException;

class UtilisateurRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "utilisateur";
    }
    protected function getNomClePrimaire(): string
    {
        return "login";
    }
    protected function getNomsColonnes(): array
    {
        return ["login", "nom", "prenom", "mdpHache", "estAdmin","email","emailAValider","nonce"];
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



    public function construireDepuisTableauSQL(array $utilisateurFormatTableau): Utilisateur
    {
        return new Utilisateur($utilisateurFormatTableau[0], $utilisateurFormatTableau[1], $utilisateurFormatTableau[2], $utilisateurFormatTableau[3], $utilisateurFormatTableau[4], $utilisateurFormatTableau[5], $utilisateurFormatTableau[6], $utilisateurFormatTableau[7]);
    }




    public static function recupererTrajetsCommePassager(Utilisateur $user) : array {
        $sql = "
        SELECT * from trajet t
        JOIN passager p on p.trajetId = t.id 
        where p.passagerLogin = :loginTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $user->getLogin()
        );
        $pdoStatement->execute($values);

        $trajets = [];

        foreach ($pdoStatement as $trajet) {
            $trajets[] = (new TrajetRepository())->construireDepuisTableauSQL($trajet);
        }

        return $trajets;
    }
}