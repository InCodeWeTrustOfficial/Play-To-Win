<?php use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Jeu;

/** @var Jeu[] $jeux */
/** @var array $modesDunJeu */
/** @var array $classementsPossibles */
/** @var string $idUser */
/** @var Jeu $jeu */
?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' id='actionField' value='actualiserJouer'>
    <input type='hidden' name='controleur' value="jouer">
    <input type='hidden' name="id" value="<?=$idUser?>">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Sélectionnez votre jeu:</label>
            <select name="jeu" id="jeu_id" required onchange="this.form.submit()">
                <?php
                    if ($jeu === null) {
                        echo '<option value="rien" selected="true">Jeu...?</option>';
                    }else {
                        echo '<option value="'.$jeu->getCodeJeu().'" selected="true">'.$jeu->getNomJeu().'</option>';
                    }
                    foreach ($jeux as $j) {
                        if($j != $jeu) {
                            echo '<option value="' . $j->getCodeJeu() . '">' . $j->getNomJeu() . '</option>';
                        }
                    }
                ?>
            </select>
        </p>
        <?php
        if(isset($_REQUEST['jeu'])){
            require 'extensionAjout.php';
        }
        ?>
        <p>
            <input type="submit" value="Valider le jeu" onclick="changeActionValue()"/>
        </p>
    </fieldset>
</form>
<script src="../ressources/scripts/formJouer.js"></script>