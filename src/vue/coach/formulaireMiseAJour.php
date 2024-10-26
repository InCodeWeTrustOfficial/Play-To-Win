<?php
/** @var Coach $coach */

use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;
?>
<?php use App\PlayToWin\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value="coach">
    <fieldset>
        <legend>Formulaire de modification de coach :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?=$coach->getId()?>" readonly ="readonly" type="text" name="id" id="id_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="biographie_id">Biographie</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $coach->getBiographie() ?>" name="biographie" id="biographie_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdp" id="mdp_id" required>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>