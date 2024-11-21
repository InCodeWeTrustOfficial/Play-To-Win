<?php
/** @var int $id */
/** @var ServiceRepository $repo */
/** @var String $controleur */
/** @var Services $service */

?>

<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value='<?= $service->getControleur() ?>'>
    <input type='hidden' name='id' value='<?= $id ?>'>
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
            <label class="InputAddOn-item" for="jeu_id">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="jeu_id" required>
                <option value="Rocket League" <?= $service->getNomJeu() === 'Rocket League' ? 'selected' : '' ?>>Rocket League</option>
                <option value="League of Legends" <?= $service->getNomJeu() === 'League of Legends' ? 'selected' : '' ?>>League of Legends</option>
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