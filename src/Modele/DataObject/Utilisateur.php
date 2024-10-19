<?php
namespace App\Covoiturage\Modele\DataObject;

use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\DataObject\Trajet;

class Utilisateur extends AbstractDataObject {
    private string $login;
    private string $nom;
    private string $prenom;
    private string $mdpHache;
    private bool $estAdmin;
    private string $email;
    private string $emailAValider;
    private string $nonce;
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
        string $mdpHache,
        bool $estAdmin,
        string $email,
        string $emailAValider,
        string $nonce
    )
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdpHache = $mdpHache;
        $this->estAdmin = $estAdmin;
        $this->email = $email;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
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

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }

    public function isAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function setAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmailAValider(): string
    {
        return $this->emailAValider;
    }

    public function setEmailAValider(string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
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