<?php use App\PlayToWin\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='connecter'>
    <input type='hidden' name='controleur' value="utilisateur">
    <fieldset>
        <legend>Connexion :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" type="text" placeholder="leblancj" name="id" id="id_id"
                   pattern="^[a-zA-Z0-9_]+$"
                   maxlength="32"
                   required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer">
        </p>
    </fieldset>
</form>