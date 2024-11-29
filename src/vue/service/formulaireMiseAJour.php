<?php
/** @var int $id */
/** @var String $controleur */
/** @var Service $service */
/** @var Jeu $jeu */
/** @var Jeu[] $jeux */

/** @var string $conf */

use App\PlayToWin\Configuration\ConfigurationSite;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\Service;

?>

<form method="<?=$conf?>" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value='<?= rawurlencode($service->getControleur()) ?>'>
    <input type='hidden' name='id' value='<?= $id ?>'>
    <input type="hidden" name="idCoach" value='<?= rawurlencode($service->getIdCoach()) ?>'>
    <fieldset>
        <legend>Modifier l'analyse Vidéo :</legend>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_services_id">Nom du service</label>
            <input class="InputAddOn-field" type="text" value="<?= htmlspecialchars($service->getNom()) ?>" name="nom_services" id="nom_services_id" required>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="description_id">Description</label>
            <textarea class="InputAddOn-field" name="description" placeholder="Une description efficace qui doit donner envie de prendre votre service !" id="description_id" rows="4" cols="50" required><?= htmlspecialchars($service->getDescriptionService()) ?></textarea>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="codeJeu">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="codeJeu">
                <?php
                if ($jeu === null) {
                    echo '<option value="rien" selected="selected">Jeu...?</option>';
                }else {
                    echo '<option value="'. rawurlencode($jeu->getCodeJeu()).'" selected="selected">'.htmlspecialchars($jeu->getNomJeu()).'</option>';
                }
                foreach ($jeux as $j) {
                    if($j != $jeu) {
                        echo '<option value="' . rawurlencode($j->getCodeJeu()) . '">' . htmlspecialchars($j->getNomJeu()) . '</option>';
                    }
                }
                ?>
            </select>
        </p>

        <?php require 'formulaireMiseAJour' . ucfirst($controleur) . '.php' ?>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="number" value="<?= rawurlencode($service->getPrixService()) ?>" name="prix" id="prix_id" required>
        </p>

        <p>
            <input type="submit" value="Envoyer" >
        </p>
    </fieldset>
</form>