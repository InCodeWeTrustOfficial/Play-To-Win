<?php

/** @var Service $service */

use App\PlayToWin\Modele\DataObject\Service;

?>

<p class="InputAddOn" id="nbJourRendu_champ">
    <label class="InputAddOn-item" for="nbJourRendu_id">Nombre de jours avant le rendu</label>
    <input class="InputAddOn-field" type="number" name="nbJourRendu" id="nbJourRendu_id" value="<?= $service->getNbJourRendu() ?>" min="1" required>
</p>