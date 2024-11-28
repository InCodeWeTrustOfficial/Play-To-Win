<?php
/** @var string $conf */
/** @var string $idUtilisateur */
/** @var string $biographieCoach */

use App\PlayToWin\Modele\DataObject\Coach;
?>
<form method="<?= $conf ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value="coach">
    <fieldset>
        <legend>Formulaire de modification de coach :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?=$idUtilisateur?>" readonly ="readonly" type="text" name="id" id="id_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="biographie_id">Biographie</label>
            <input class="InputAddOn-field" type="text" value="<?= $biographieCoach ?>" name="biographie" id="biographie_id" required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="entrez votre mot de passe" name="mdp" id="mdp_id" maxlength="128" required>
        </p>

        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>