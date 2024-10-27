<?php use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Langue;

/** @var Langue[] $langues */
/** @var string $idUser */
?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='ajouterLangue'>
    <input type='hidden' name='controleur' value="langue">
    <input type='hidden' name="id" value="<?=$idUser?>">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="lang_id">Sélectionnez votre langue principale (vous pourrez plus tard en avoir plusieurs):</label>
            <select name="lang" id="lang_id" required>
                <?php
                echo '<option value="rien" selected="true">Langue...?</option>';
                foreach ($langues as $l){
                    echo '<option value="'.$l->getCodeAlpha().'">'.$l->getNom().'</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>