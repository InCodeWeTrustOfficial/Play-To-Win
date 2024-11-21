<?php
/** @var string $id */
/** @var Coach $coach */
use App\PlayToWin\Modele\DataObject\Coach;
use App\PlayToWin\Modele\Repository\Single\CoachRepository;
$coach = (new CoachRepository())->recupererParClePrimaire($id);
?>
<?php use App\PlayToWin\Configuration\ConfigurationSite;?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php" enctype="multipart/form-data">
    <input type='hidden' name='action' value='mettreAJourBanniere'>
    <input type='hidden' name='controleur' value="coach">
    <input type='hidden' name='id' value="<?=$id?>">
    <fieldset>
        <legend>Modification de votre bannière de coach :</legend>
        <p>
            Image actuelle :
            <img src="../<?=$coach->getBannierePath()?>" alt="Bannière" style="width: 70px; height: 70px; object-fit: cover;"
                 onerror="this.onerror=null; this.src='../ressources/img/defaut_banniere.png';">
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="ban_id">Entrez votre nouvelle bannière:</label>
            <input class="InputAddOn-field" type="file" name="<?=rawurlencode($id)?>" id="ban_id" required>
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