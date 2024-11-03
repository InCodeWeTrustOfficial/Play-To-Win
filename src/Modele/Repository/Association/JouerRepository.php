<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\ModeDeJeu;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\Single\ClassementRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;
use App\PlayToWin\Modele\Repository\Single\ModeDeJeuRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;
use PDOException;

class JouerRepository extends AbstractAssociationRepository {


    protected function getNomsClePrimaire(): array {
        return array((new JeuRepository())->getNomClePrimaire(),(new UtilisateurRepository())->getNomClePrimaire(),(new ModeDeJeuRepository())->getNomClePrimaire(),(new ClassementRepository())->getNomClePrimaire());
    }

    protected function getNomTable(): string {
        return "p_jouer";
    }

    protected function getNomsColonnes(): array {
        $cles = $this->getNomsClePrimaire();
        return array($cles[0],$cles[1],$cles[2],$cles[3]);
    }

    protected function formatTableauSQL(array $objet, bool $truc=true): array
    {
        $array = array(":cle1Tag" => $objet[0], ":cle2Tag" => $objet[1] ,":cle3Tag" => $objet[2]);
        if($truc){
            $array[":cle4Tag"] = $objet[3];
        }
        return $array;
    }

    public function countModesJeu(string $cle):int{
        return parent::countParObjectClePrimaire((new JeuRepository()),array(new ModeDeJeuRepository()),$cle);
    }

    public function recupererModeJeuClassement(string $idUtilisateur) : ?array{
        return $this->recupererListeParObjetClePrimaire((new UtilisateurRepository()),array(new JeuRepository(), new ModeDeJeuRepository(), new ClassementRepository()),$idUtilisateur);
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): mixed
    {
        return array((new JeuRepository())->recupererParClePrimaire($objetFormatTableau[0]),
                     (new UtilisateurRepository())->recupererParClePrimaire($objetFormatTableau[1]),
                     (new ModeDeJeuRepository())->recupererParClePrimaire($objetFormatTableau[2]),
                     (new ClassementRepository())->recupererParClePrimaire($objetFormatTableau[3]));
    }
    public function modifJouer(array $keys, string $classement) : bool{
        $bool = true;

        try {

            $tab = $keys;
            $tab[] = $classement;

            $recupTag = $this->recupererTags($keys);

            $clesPrim = $this->getNomsClePrimaire();

            $sql = "UPDATE " . $this->getNomTable() . " SET " . $clesPrim[3] . " = :cle4Tag " . $recupTag;

            $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

            $values = $this->formatTableauSQL($tab);

            $pdoStatement->execute($values);
        } catch(PDOException $e){
            MessageFlash::ajouter("danger",$e->getMessage());
            MessageFlash::ajouter("info",$sql);
            $bool = false;
        }
        return $bool;
    }
}