<?php
use App\PlayToWin\Modele\DataObject\Jeu;

/** @var Jeu[] $jeux */
/** @var array $modesDunJeu */
/** @var array $classementsPossibles */
/** @var string $idUser */
/** @var Jeu $jeu */
/** @var string $codeJeu */
/** @var string $nomJeu */

/** @var string $conf */
?>
<form method="<?=$conf ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' id='actionField' value='actualiserJouer'>
    <input type='hidden' name='controleur' value="jouer">
    <input type='hidden' name="id" value="<?=$idUser?>">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Sélectionnez votre jeu:</label>
            <select name="jeu" id="jeu_id" onchange="this.form.submit()">
                <?php
                    if ($jeu === null) {
                        echo '<option value="rien" selected="selected">Jeu...?</option>';
                    }else {
                        echo '<option value="'.$codeJeu.'" selected="selected">'.$nomJeu.'</option>';
                    }
                    foreach ($jeux as $j) {
                        if($j != $jeu) {
                            echo '<option value="' . rawurlencode($j->getCodeJeu()) . '">' . htmlspecialchars($j->getNomJeu()) . '</option>';
                        }
                    }
                ?>
            </select>
        </p>
        <?php
        /** @var boolean $reqJeu */
        if($reqJeu){
            require 'extensionAjout.php';
        }
        ?>
        <p>
            <input type="submit" value="Valider le jeu" onclick="changeActionValue()">
        </p>
    </fieldset>
</form>
<script src="../ressources/scripts/formJouer.js"></script>