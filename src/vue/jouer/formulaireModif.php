<?php use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Jeu;

/** @var array $classementsPossibles */
/** @var string $idUser */
/** @var Jeu $jeu */
/** @var string $mode */
/** @var string $conf */
/** @var string $codeJeu */
/** @var string $nomJeu */
/** @var string $nomMode */
?>
<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='modifJouer'>
    <input type='hidden' name='controleur' value="jouer">
    <input type='hidden' name="id" value="<?=rawurlencode($idUser)?>">
    <input type = 'hidden' name="jeu" value="<?=$codeJeu?>">
    <input type = 'hidden' name="mode" value="<?=$mode?>">
    <fieldset>
        <legend>Modification:</legend>
        <p class="nomModif">
            <?= $nomJeu?> <img class="jeuModif" src="../<?=$jeu->getPathLogo()?>">
        </p>
        <p class="nomModif">
            Le mode choisi : <?=htmlspecialchars($nomMode)?>
        </p>
        <?php
        require_once 'extClassement.php';
        ?>
        <p>
            <input type="submit" value="Valider classement"/>
        </p>
    </fieldset>
</form>