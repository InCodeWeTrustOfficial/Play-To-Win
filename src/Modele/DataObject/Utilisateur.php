<?php
namespace App\PlayToWin\Modele\DataObject;

use App\PlayToWin\Modele\Repository\UtilisateurRepository;
use App\PlayToWin\Modele\DataObject\Trajet;
use DateTime;

class Utilisateur extends AbstractDataObject {
    private string $idUtilisateur;
    private string $nom;
    private string $prenom;
    private string $pseudo;
    private string $email;
    private string $emailAValider;
    private string $nonce;
    private DateTime $dateNaissance;
    private string $mdpHache;
    private bool $estAdmin;

    private static $pathAvatar = "ressources/img/uploads/pp_utilisateurs/";

    public function __construct(
        string $idUtilisateur,
        string $nom,
        string $prenom,
        string $pseudo,
        string $email,
        string $emailAValider,
        string $nonce,
        DateTime $dateNaissance,
        string $mdpHache,
        bool $estAdmin
    )
    {
        $this->idUtilisateur = $idUtilisateur;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
        $this->dateNaissance = $dateNaissance;
        $this->mdpHache = $mdpHache;
        $this->estAdmin = $estAdmin;
    }

    public function getId(): string
    {
        return $this->idUtilisateur;
    }
    public function setId(string $idUtilisateur): void
    {
        $this->idUtilisateur = $idUtilisateur;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }
    public function getPseudo(): string
    {
        return $this->pseudo;
    }
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
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
    public function getDateNaissance(): DateTime
    {
        return $this->dateNaissance;
    }
    public function setDateNaissance(DateTime $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }
    public function isAdmin(): bool
    {
        return $this->estAdmin;
    }
    public function setAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }
    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }
    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }
    public function getAvatarPath(): string {
        $ext = "";
        if(file_exists(__DIR__ ."/../../../ressources/img/uploads/pp_utilisateurs/".$this->idUtilisateur.".png")){
            $ext = ".png";
        } else if (file_exists(__DIR__ ."/../../../ressources/img/uploads/pp_utilisateurs/".$this->idUtilisateur.".jpg")){
            $ext = ".jpg";
        }
        return $this::$pathAvatar.$this->idUtilisateur.$ext;
    }
}
?>