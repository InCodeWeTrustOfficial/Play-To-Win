<?php

namespace App\PlayToWin\Modele\Repository\Association;

use App\PlayToWin\Lib\MessageFlash;
use App\PlayToWin\Modele\DataObject\AbstractDataObject;
use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\Repository\ConnexionBaseDeDonnees;
use App\PlayToWin\Modele\Repository\Single\ClassementRepository;
use App\PlayToWin\Modele\Repository\Single\JeuRepository;

class SeClasserRepository extends AbstractAssociationRepository {


    protected function getNomsClePrimaire(): array
    {
        return array((new ClassementRepository())->getNomClePrimaire(),(new JeuRepository())->getNomClePrimaire());
    }

    protected function formatTableauSQL(array $objet): array
    {
        return array(
          "cle1Tag" => $objet[0],
          "cle2Tag" => $objet[1],
          "cle3Tag" => $objet[2],
          "cle4Tag" => $objet[3],
          "cle5Tag" => $objet[4],
          "cle6Tag" => $objet[5],
        );
    }

    protected function getNomTable(): string
    {
        return "p_seClasser";
    }

    protected function getNomsColonnes(): array
    {
        $cp = $this->getNomsClePrimaire();
        return array($cp[0], $cp[1],"place","eloMin","eloMax","cumulElo");
    }

    protected function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject
    {
        return new ClassementJeu(
            (new ClassementRepository())->recupererParClePrimaire($objetFormatTableau[0]),
            (new JeuRepository())->recupererParClePrimaire($objetFormatTableau[1]),
            $objetFormatTableau[2],
            $objetFormatTableau[3],
            $objetFormatTableau[4],
            $objetFormatTableau[5]
        );
    }
    public function recuperer(): ?array {
        return parent::recuperer();
    }

    public function recupererAvecJeu(string $cle): ?array {

        $sql = "select ".join(',',$this->getNomsColonnes())." from ".$this->getNomTable()." sc where sc.".$this->getNomsClePrimaire()[1]." = :cleTag order by ".$this->getNomsColonnes()[2].";";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array("cleTag" => $cle);

        $pdoStatement->execute($values);

        $liste = array();

        foreach ($pdoStatement as $row) {
            $liste[] = $this->construireDepuisTableauSQL($row);
        }
        if ($liste !== null) {
            $liste = array_filter($liste, function ($sc) use ($cle) {
                return $sc->getCodeJeu() === $cle;
            });
        }

        return $liste;
    }

    public function recupererDepuisJouer(array $jouer): ?AbstractDataObject {

        $sql = "SELECT ".join(',',$this->getNomsColonnes())." FROM ".$this->getNomTable()." WHERE ".(new ClassementRepository())->getNomClePrimaire()." = :classTag AND ".(new JeuRepository())->getNomClePrimaire(). " = :jeuTag;";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "jeuTag" => $jouer[0]->getCodeJeu(),
            "classTag" => $jouer[2]->getIdClassement()
        );

        $pdoStatement->execute($values);

        $objet = $pdoStatement->fetch();

        if($objet == null) {
            //MessageFlash::ajouter("info",$sql);
            return null;
        }
        return $this->construireDepuisTableauSQL($objet);
    }
}