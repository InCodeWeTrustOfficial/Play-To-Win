<?php

use App\PlayToWin\Modele\DataObject\Services;

echo "<h2>Liste des services proposés</h2>";
/** @var Services[] $services */
/** @var string $controleur  */

?>

<form action="controleurFrontal.php" method="post">
    <input type='hidden' name='action' id="action" value='afficherListe'>
    <input type='hidden' name='controleur' value='service'>

    <label for="service">Sélectionnez un service :</label>
    <select id="service" name="service" onchange="updateAction()">
        <option value="">Tous</option>
        <option value="coaching">Coaching</option>
        <option value="analyse_video">Analyse vidéo</option>
    </select>
    <input type="submit" value="Envoyer">
</form>

<div class="service-container">
    <?php foreach ($services as $service): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=<?php echo $controleur; ?>&action=afficherDetail&codeService=<?php echo $service->getCodeService(); ?>">
            <div class="service-card">
                <img src="../ressources/img/jeux/<?php echo $service->getNomJeu(); ?>.png" alt="Icon" class="service-icon">
                <div class="service-name"><?php echo $service->getNomService(); ?></div>
                <div class="service-description"><?php echo $service->getDescriptionService(); ?></div>
                <div class="service-price"><?php echo number_format($service->getPrixService(), 2); ?> €</div>
                <div class="service-price"><?php echo $service->getTypeService(); ?></div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<br>
<div class="btn">
    <a href="../web/controleurFrontal.php?controleur=service&action=afficherFormulaireProposerService" class="btn new-service-btn">Nouveau</a>
</div>

<script>
    function updateAction() {
        const serviceSelect = document.getElementById("service");
        const actionInput = document.getElementById("action");

        if (serviceSelect.value === "coaching") {
            actionInput.value = "afficherListeCoaching";
        } else if (serviceSelect.value === "analyse_video") {
            actionInput.value = "afficherListeAnalyse";
        } else {
            actionInput.value = "afficherListe";
        }
    }
</script>