<?php
namespace App\Covoiturage\Modele\DataObject;

use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\DataObject\Trajet;

class Utilisateur extends AbstractDataObject {
    private string $login;
    private string $nom;
    private string $prenom;
    private ?array $trajetsCommePassager;


    // un getter
    public function getNom(): string
    {
        return $this->nom;
    }

    // un setter
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    // un constructeur
    public function __construct(
        string $login,
        string $nom,
        string $prenom,
    )
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->trajetsCommePassager = null;
    }

    public function getTrajetsCommePassager(): ?array
    {
        if($this->trajetsCommePassager == null){
            $this->trajetsCommePassager = UtilisateurRepository::recupererTrajetsCommePassager($this);
        }
        return $this->trajetsCommePassager;
    }

    public function setTrajetsCommePassager(?array $trajetsCommePassager): void
    {
        $this->trajetsCommePassager = $trajetsCommePassager;
    }

    /**
     * @return mixed
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    /**
    // Pour pouvoir convertir un objet en chaîne de caractères
    public function __toString(): string
    {
        return "$this->nom $this->prenom de login $this->login";
    }
     * */
}
?>