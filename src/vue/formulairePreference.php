<?php
/** @var string $conf */

/** @var boolean $preferenceExiste */
/** @var string $controleurPref */
?>

<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='enregistrerPreference'>
    <fieldset>
        <legend>Quelle est votre préférence ?</legend>
        <input type="radio" id="utilisateurId" name="controleur_defaut" value="jeux" <?php if($preferenceExiste){if($controleurPref == "jeux"){echo "checked";}} ?>>
        <label for="utilisateurId">Page Jeu ?</label>
        <input type="radio" id="trajetId" name="controleur_defaut" value="coach" <?php if($preferenceExiste){if($controleurPref == "coach"){echo "checked";}} ?>>
        <label for="trajetId">Page Coach ?</label>
        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>