<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use DateTime;

class TrajetRepository extends AbstractRepository {

    protected function getNomTable(): string
    {
        return "trajet";
    }
    protected function getNomClePrimaire(): string
    {
        return "id";
    }
    protected function getNomsColonnes(): array
    {
        return ["id", "depart", "arrivee","date","prix","conducteurLogin","nonFumeur"];
    }

    protected function formatTableauSQL(AbstractDataObject $t): array
    {
        /** @var Trajet $t */
        return array(
            ":idTag" => $t->getId(),
            ":departTag" => $t->getDepart(),
            ":arriveeTag" => $t->getArrivee(),
            ":dateTag" => $t->getDate()->format("Y-m-d"),
            ":prixTag" => $t->getPrix(),
            ":conducteurLoginTag" => $t->getConducteur()->getId(),
            ":nonFumeurTag" => $t->isNonFumeur()?1:0
        );
    }

    protected function construireDepuisTableauSQL(array $trajetTableau) : Trajet {
        $t =
            new Trajet(
                $trajetTableau["id"],
                $trajetTableau["depart"],
                $trajetTableau["arrivee"],
                new dateTime($trajetTableau["date"]),
                $trajetTableau["prix"],
                (new UtilisateurRepository())->recupererParClePrimaire($trajetTableau["conducteurLogin"]),
                $trajetTableau["nonFumeur"]
            );
        $t->setPassagers(self::recupererPassagers($t));

        return $t;
    }

    private static function recupererPassagers(Trajet $t) : array {
        $sql = "
        SELECT u.login, u.nom, u.prenom
        FROM utilisateur u 
        JOIN passager p ON u.login = p.passagerLogin
        WHERE p.trajetId = :idTag
        ";

        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->prepare($sql);

        $values = array(
            "idTag" => $t->getId()
        );

        $pdoStatement->execute($values);

        $users = array();

        foreach($pdoStatement as $user) {
            $users[] = (new UtilisateurRepository())->construireDepuisTableauSQL($user);
        }

        return $users;

    }
    public static function supprimerPassager(Trajet $t, string $passagerLogin) : bool{


        $sql= "
        delete from passager where passagerLogin = :passagerTag and trajetId = :idTag
        ";
        $pdoStatement = ConnexionBaseDeDonnees::getPDO()->prepare($sql);

        $values = array(
            "passagerTag" => $passagerLogin,
            "idTag" => $t->getId()
        );

        $pdoStatement->execute($values);

        return $pdoStatement->rowCount() > 0;
    }
}