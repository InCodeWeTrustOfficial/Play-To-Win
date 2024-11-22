<?php
/** @var int $id */
/** @var ServiceRepository $repo */
/** @var String $controleur */
/** @var Services $service */
/** @var Jeu $jeu */
/** @var Jeu[] $jeux */
?>

<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value='<?= $service->getControleur() ?>'>
    <input type='hidden' name='id' value='<?= $id ?>'>
    <input type="hidden" name="idCoach" value='<?= $service->getCoach() ?>'>
    <fieldset>
        <legend>Modifier l'analyse Vidéo :</legend>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_services_id">Nom du service</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $service->getNomService() ?>" name="nom_services" id="nom_services_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="description_id">Description</label>
            <textarea class="InputAddOn-field" name="description" placeholder="<?= $service->getDescriptionService() ?>" id="description_id" rows="4" cols="50" required></textarea>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="codeJeu">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="codeJeu">
                <?php
                if ($jeu === null) {
                    echo '<option value="rien" selected="selected">Jeu...?</option>';
                }else {
                    echo '<option value="'.$jeu->getCodeJeu().'" selected="selected">'.$jeu->getNomJeu().'</option>';
                }
                foreach ($jeux as $j) {
                    if($j != $jeu) {
                        echo '<option value="' . $j->getCodeJeu() . '">' . $j->getNomJeu() . '</option>';
                    }
                }
                ?>
            </select>
        </p>

        <?php require 'formulaireMiseAJour' . ucfirst($controleur) . '.php' ?>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="number" placeholder="<?= $service->getPrixService() ?>" name="prix" id="prix_id" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>