<?php
/** @var boolean $estModif */
/** @var string $action */
/** @var string $controleur */
/** @var string $conf */

/** @var string $biographieCoach */

/** @var string $idUtilisateurr */
/** @var string $pseudoUtilisateurr */

/** @var string $titreForm */
?>
<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='<?=$action?>'>
    <input type='hidden' name='controleur' value="<?=$controleur?>">
    <fieldset>
        <legend><?=$titreForm?></legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?= $idUtilisateurr ?>" readonly ="readonly" type="text" name="id" id="id_id" required>
        </p>
        <?php if(!$estModif): ?>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="pseudo_id">Pseudo</label>
            <input class="InputAddOn-field" type="text" readonly="readonly" value="<?= $pseudoUtilisateurr ?>" name="pseudo" id="pseudo_id" required>
        </p>

        <?php endif ?>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="biographie_id">Biographie</label>
            <input class="InputAddOn-field" type="text" <?php if($estModif) {echo 'value="'.$biographieCoach.'"';}?>placeholder="Présentez vous en tant que coach : mettez vous en valeur !" name="biographie" id="biographie_id" required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" placeholder="entrez votre mot de passe" name="mdp" id="mdp_id" maxlength="128" required>
        </p>

        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>