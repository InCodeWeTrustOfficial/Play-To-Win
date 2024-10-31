<?php use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Classement;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\ModeDeJeu;

/** @var Jeu[] $jeux */
/** @var ModeDeJeu[] $modes */
/** @var Classement[] $classements */
/** @var string $idUser */
?>
<form method="<?php if(ConfigurationSite::getDebug()){echo "get";}else{echo "post";} ?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='ajouterJouer'>
    <input type='hidden' name='controleur' value="jouer">
    <input type='hidden' name="id" value="<?=$idUser?>">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Sélectionnez votre jeu:</label>
            <select name="jeu" id="jeu_id" required>
                <?php
                echo '<option value="rien" selected="true">Jeu...?</option>';
                foreach ($jeux as $j){
                    echo '<option value="'.$j->getNomJeu().'">'.$j->getNomJeu().'</option>';
                }
                ?>
            </select>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mode_id">Sélectionnez votre mode:</label>
            <select name="mode" id="mode_id" required>
                <?php
                echo '<option value="rien" selected="true">mode...?</option>';
                foreach ($modes as $m){
                    echo '<option value="'.$m->getNomMode().'">'.$m->getNomMode().'</option>';
                }
                ?>
            </select>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="class_id">Sélectionnez votre classement:</label>
            <select name="class" id="class_id" required>
                <?php
                echo '<option value="rien" selected="true">Langue...?</option>';
                foreach ($classements as $c){
                    echo '<option value="'.$c->getIdClassement().'">'.$c->getNomClassement().' '.$c->getDivisionClassement().'</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
    </form><?php
