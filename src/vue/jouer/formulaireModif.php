<?php use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Jeu;

/** @var array $classementsPossibles */
/** @var string $idUser */
/** @var Jeu $jeu */
/** @var string $mode */
?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='modifJouer'>
    <input type='hidden' name='controleur' value="jouer">
    <input type='hidden' name="id" value="<?=$idUser?>">
    <input type = 'hidden' name="jeu" value="<?=$jeu->getCodeJeu()?>">
    <input type = 'hidden' name="mode" value="<?=$mode?>">
    <fieldset>
        <legend>Modification:</legend>
        <p class="InputAddOn">
            Jeu : <?= $jeu->getNomJeu()?>
            Mode : <?= $mode?>
        </p>
        <?php
        require_once 'extClassement.php';
        ?>
        <p>
            <input type="submit" value="Valider classement"/>
        </p>
    </fieldset>
</form>