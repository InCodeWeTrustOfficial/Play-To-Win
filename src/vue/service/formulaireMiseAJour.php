<?php
/** @var int $codeService */

use App\Covoiturage\Modele\Repository\AnalyseVideoRepository;
use App\Covoiturage\Modele\Repository\ServiceRepository;

$service = (new AnalyseVideoRepository())->recupererParClePrimaire($codeService);

?>
<form method="get" action="controleurFrontal.php">
    <input type='hidden' name='action' value='mettreAJour'>
    <input type='hidden' name='controleur' value='service'>
    <fieldset>
        <legend>Modifier le Service :</legend>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_services_id">Nom du service</label>
            <input class="InputAddOn-field" type="text" placeholder="<?= $service->getNomService() ?>" name="nom_services" id="nom_services_id" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="description_id">Description</label>
            <textarea class="InputAddOn-field" name="description" id="description_id" rows="4" cols="50" required><?= $service->getDescriptionService() ?></textarea>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="jeu_id">Jeu</label>
            <select class="InputAddOn-field" name="jeu" id="jeu_id" required>
                <option value="Rocket League" <?= $service->getNomJeu() === 'Rocket League' ? 'selected' : '' ?>>Rocket League</option>
                <option value="League of Legends" <?= $service->getNomJeu() === 'League of Legends' ? 'selected' : '' ?>>League of Legends</option>
            </select>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="type_id">Type de service</label>
            <select class="InputAddOn-field" name="type" id="type_id" required onchange="toggleFields()">
                <option value="Analyse vidéo" <?= $service->getTypeService() === 'Analyse vidéo' ? 'selected' : '' ?>>Analyse vidéo</option>
                <option value="Coaching" <?= $service->getTypeService() === 'Coaching' ? 'selected' : '' ?>>Coaching</option>
            </select>
        </p>

        <p class="InputAddOn" id="date_champ" style="display:none;">
            <label class="InputAddOn-item" for="date_id">Date</label>
            <input class="InputAddOn-field" type="date" name="date" id="date_id"/>
        </p>

        <p class="InputAddOn" id="nbJourRendu_champ" style="display:<?= $service->getTypeService() === 'Analyse vidéo' ? 'block' : 'none' ?>;">
            <label class="InputAddOn-item" for="nbJourRendu_id">Nombre de jours avant le rendu</label>
            <input class="InputAddOn-field" type="number" name="nbJourRendu" id="nbJourRendu_id" placeholder="<?= $service->getNbJourRendu() ?>" min="1" required/>
        </p>

        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prix_id">Prix</label>
            <input class="InputAddOn-field" type="number" placeholder="<?= $service->getPrixService() ?>" name="prix" id="prix_id" required/>
        </p>

        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>

<script>
    toggleFields();

    function toggleFields() {
        var typeSelect = document.getElementById("type_id");
        var dateField = document.getElementById("date_champ");
        var daysBeforeField = document.getElementById("nbJourRendu_champ");

        if (typeSelect.value === "Analyse vidéo") {
            dateField.style.display = "none";
            daysBeforeField.style.display = "block";
        } else if (typeSelect.value === "Coaching") {
            dateField.style.display = "block";
            daysBeforeField.style.display = "none";
        }
    }
</script>
