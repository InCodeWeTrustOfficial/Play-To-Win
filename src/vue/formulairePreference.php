<?php
use App\Covoiturage\Lib\PreferenceControleur;
?>

<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='enregistrerPreference'>
    <fieldset>
        <legend>Quelle est votre préférence ?</legend>
        <input type="radio" id="utilisateurId" name="controleur_defaut" value="utilisateur" <?php if(PreferenceControleur::existe()){if(PreferenceControleur::lire() == "utilisateur"){echo "checked";}} ?>>
        <label for="utilisateurId">Utilisateur</label>
        <input type="radio" id="trajetId" name="controleur_defaut" value="trajet" <?php if(PreferenceControleur::existe()){if(PreferenceControleur::lire() == "trajet"){echo "checked";}} ?>>
        <label for="trajetId">Trajet</label>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>