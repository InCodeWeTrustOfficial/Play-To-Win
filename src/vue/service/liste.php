<?php

use App\PlayToWin\Modele\DataObject\Service;

echo "<h2>Liste des services proposés</h2>";
/** @var Service[] $services */
/** @var string $id  */
?>

<form action="controleurFrontal.php" method="get">
    <input type='hidden' name='action' id="action" value='afficherListe'>
    <input type='hidden' name='controleur' value='service'>
    <input type='hidden' name='id' value='<?php echo rawurlencode($id); ?>'>

    <label id="service">Sélectionnez un service :</label>
    <select id="service_type_field" name="service_type_field" onchange="updateAction()">
        <option value="tous">Tous</option>
        <option value="coaching">Coaching</option>
        <option value="analyse_video">Analyse vidéo</option>
    </select>
    <input type="submit" value="Envoyer">
</form>

<div class="service-container">
    <?php foreach ($services as $service): ?>
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=<?php echo $service->getControleur(); ?>&action=afficherDetail&id=<?php echo $service->getId(); ?>">
            <div class="service-card">
                <img src="../ressources/img/jeux/<?= rawurlencode($service->getCodeJeu())?>.png" alt="Icon" class="service-icon">
                <div class="service-name"><?php echo htmlspecialchars($service->getNomService()); ?></div>
                <div class="service-description"><?php echo htmlspecialchars($service->getDescriptionService()); ?></div>
                <div class="service-price">
                    <?php if ($service->getPrixService() > 0):
                        echo number_format($service->getPrixService(), 2); ?> €
                    <?php else:
                        echo "gratuit";
                    endif;
                    ?>
                </div>
                <div class="service-price"><?php echo $service->getControleur(); ?></div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<br>

<div class="btn">
    <a href="../web/controleurFrontal.php?controleur=service&action=afficherFormulaireCreation" class="btn new-service-btn">Nouveau</a>
</div>