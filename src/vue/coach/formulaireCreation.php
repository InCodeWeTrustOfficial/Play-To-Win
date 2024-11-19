<?php
/** @var Utilisateur $utilisateur */
/** @var string $controleur */
use App\PlayToWin\Modele\DataObject\Utilisateur;
use App\PlayToWin\Modele\Repository\Single\UtilisateurRepository;
?>
<?php use App\PlayToWin\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='creerDepuisFormulaire'>
    <input type='hidden' name='controleur' value="<?=$controleur?>">
    <fieldset>
        <legend>Formulaire d'inscription de coach :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="id_id">id</label>
            <input class="InputAddOn-field" value="<?= $utilisateur->getId() ?>" readonly ="readonly" type="text" name="id" id="id_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="pseudo_id">Pseudo</label>
            <input class="InputAddOn-field" type="text" readonly="readonly" value="<?= $utilisateur->getPseudo()?>" name="pseudo" id="pseudo_id" required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="biographie_id">Biographie</label>
            <input class="InputAddOn-field" type="text" placeholder="Présentez vous en tant que coach : mettez vous en valeur !" name="biographie" id="biographie_id" required>
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