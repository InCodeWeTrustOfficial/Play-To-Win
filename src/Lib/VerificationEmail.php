<?php

namespace App\PlayToWin\Lib;

use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Utilisateur $utilisateur): void {
        $destinataire = $utilisateur->getEmailAValider();
        $sujet = "Validation de l'adresse email";
        // Pour envoyer un email contenant du HTML
        $enTete = "MIME-Version: 1.0\r\n";
        $enTete .= "Content-type:text/html;charset=UTF-8\r\n";

        // Corps de l'email
        $idURL = rawurlencode($utilisateur->getId());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $URLAbsolue = ConfigurationSite::getURLAbsolue();
        $lienValidationEmail = "$URLAbsolue?action=validerEmail&controleur=utilisateur&id=$idURL&nonce=$nonceURL";
        $corpsEmailHTML = "<a href=\"$lienValidationEmail\">Validation</a>";

        // http://localhost/s3-projetweb/web/controleurFrontal.php?action=validerEmail&controleur=utilisateur&id=IDAINSERER&nonce=NONCEACOPIERCOLLER
        //http://localhost/s3-projetweb/web/controleurFrontal.php?action=validerEmail&controleur=utilisateur&id=<h1>Hack&nonce=X6WQBd6FtxK1/tPfHXTeL9

        // Temporairement avant d'envoyer un vrai mail
        echo "Simulation d'envoi d'un mail<br> Destinataire : $destinataire<br> Sujet : $sujet<br> Corps : <br>$corpsEmailHTML";

        // Quand vous aurez configué l'envoi de mail via PHP
        mail($destinataire, $sujet, $corpsEmailHTML, $enTete);
    }

    public static function traiterEmailValidation($id, $nonce): bool {
        /** @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($id);

        if($utilisateur != null && $utilisateur->getNonce() == $nonce) {
            $utilisateur->setEmail($utilisateur->getEmailAValider());
            $utilisateur->setEmailAValider("");
            $utilisateur->setNonce("");
            (new UtilisateurRepository())->mettreAJour($utilisateur);
            return true;
        }
        return false;
    }

    public static function aValideEmail(Utilisateur $utilisateur) : bool {
        return $utilisateur->getEmail()!=""?1:0;
    }
}

