<?php
/** @var string $login */
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
$utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
?>
<form method="get" action = "controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <fieldset>
        <legend>Formulaire de modification :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login</label>
            <input class="InputAddOn-field" value="<?= $login ?>" readonly ="readonly" type="text" name="login" id="login_id" required/>

        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getNom()?>" name="nom" id="nom_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom</label>
            <input class="InputAddOn-field" type="text"  placeholder="<?= $utilisateur->getPrenom()?>" name="prenom" id="prenom_id" required/>

        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>