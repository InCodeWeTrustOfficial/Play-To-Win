<?php
/** @var int $codeService */

use App\PlayToWin\Modele\Repository\Single\CoachingRepository;

$exemplaireservice = (new CoachingRepository())->recupererParClePrimaire($codeService);

?>
<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value='<?= $exemplaireservice->getTypeService() ?>'>
    <input type='hidden' name='id' value='<?= $codeService ?>'>
    <fieldset>
        <legend>Modifier le Coaching :</legend>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_services_id">Nom du service</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $exemplaireservice->getNomService() ?>" name="nom_services" id="nom_services_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="description_id">Description</label>
            <textarea class="InputAddOn-field" name="description" placeholder="<?= $exemplaireservice->getDescriptionService() ?>" id="description_id" rows="4" cols="50" required></textarea>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="jeu_id" required>
                <option value="Rocket League" <?= $exemplaireservice->getNomJeu() === 'Rocket League' ? 'selected' : '' ?>>Rocket League</option>
                <option value="League of Legends" <?= $exemplaireservice->getNomJeu() === 'League of Legends' ? 'selected' : '' ?>>League of Legends</option>
            </select>
        </p>

        <p class="InputAddOn" id="date_champ" >
            <label class="InputAddOn-item" for="duree_id">Duree du coaching</label>
            <input class="InputAddOn-field" type="number" name="duree" id="duree_id" placeholder="Ex : 30 min" min="0" step="15" />
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="number" placeholder="<?= $exemplaireservice->getPrixService() ?>" name="prix" id="prix_id" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>