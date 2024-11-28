<?php
/** @var string $id */
/** @var Utilisateur $utilisateur */

/** @var boolean $conf */

/** @var string $idHTML */
/** @var string $nomHTML */
/** @var string $prenomHTML */
/** @var string $pseudoHTML */
/** @var string $emailHTML */
/** @var string $dateYYYYMMJJ */

use App\PlayToWin\Modele\DataObject\Utilisateur;
?>
<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value="utilisateur">
    <fieldset>
        <legend>Formulaire de modification :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?= $idHTML ?>" readonly ="readonly" type="text" name="id" id="id_id" required>

        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text"  value="<?= $nomHTML?>" name="nom" id="nom_id" maxlength="32" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prenom</label>
            <input class="InputAddOn-field" type="text"  value="<?= $prenomHTML?>" name="prenom" id="prenom_id" maxlength="32" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="pseudo_id">Pseudo</label>
            <input class="InputAddOn-field" type="text"  value="<?= $pseudoHTML ?>" name="pseudo" id="pseudo_id" maxlength="32" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="email_id">Email</label>
            <input class="InputAddOn-field" type="text"  value="<?= $emailHTML ?>" name="email" id="email_id" maxlength="256" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="date_id">Date de naissance</label>
            <input class="InputAddOn-field" type="date" value="<?= $dateYYYYMMJJ?>" name="date" id="date_id"  required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="amdp_id">Ancien mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="entrez votre ancien mot de passe" name="amdp" id="amdp_id" maxlength="128" required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Nouveau Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="entrez votre nouveau mot de passe" name="mdp" id="mdp_id" maxlength="128" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp2_id">Vérification du nouveau mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="entrez une deuxième fois votre nouveau mot de passe" name="mdp2" id="mdp2_id" maxlength="128" required>
        </p>

        <?php
        /** @var boolean $estAdmin */
        /** @var boolean $utilAdmin */
        if ($estAdmin){
            echo '
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
            <input class="InputAddOn-field" type="checkbox" name="estAdmin" id="estAdmin_id"';
        if ($utilAdmin) {
            echo " checked";
        } echo '>
        </p>
        ';}
        ?>

        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>