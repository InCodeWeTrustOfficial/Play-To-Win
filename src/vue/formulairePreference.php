<?php
use App\PlayToWin\Lib\PreferenceControleur;
/** @var string $conf */

/** @var boolean $preferenceExiste */
/** @var string $controleurPref */
?>

<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='enregistrerPreference'>
    <fieldset>
        <legend>Quelle est votre préférence ?</legend>
        <input type="radio" id="utilisateurId" name="controleur_defaut" value="utilisateur" <?php if($preferenceExiste){if($controleurPref == "utilisateur"){echo "checked";}} ?>>
        <label for="utilisateurId">Utilisateur</label>
        <input type="radio" id="trajetId" name="controleur_defaut" value="trajet" <?php if($preferenceExiste){if($controleurPref == "trajet"){echo "checked";}} ?>>
        <label for="trajetId">Trajet</label>
        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>