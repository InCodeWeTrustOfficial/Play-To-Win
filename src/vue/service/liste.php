<?php

use App\PlayToWin\Modele\DataObject\Services;

echo "<h2>Liste des services proposés</h2>";
/** @var Services[] $services */
/** @var string $controleur  */
/** @var string $id  */
?>

<form action="controleurFrontal.php" method="get">
    <input type='hidden' name='action' id="action" value='afficherListe'>
    <input type='hidden' name='controleur' value='service'>
    <input type='hidden' name='id' value='<?php echo htmlspecialchars($id); ?>'>

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
        <a class="detail-link" href="../web/controleurFrontal.php?controleur=<?php echo $controleur; ?>&action=afficherDetail&codeService=<?php echo $service->getId(); ?>">
            <div class="service-card">
                <img src="../ressources/img/jeux/<?=$service->getCodeJeu()?>.png" alt="Icon" class="service-icon">
                <div class="service-name"><?php echo $service->getNomService(); ?></div>
                <div class="service-description"><?php echo $service->getDescriptionService(); ?></div>
                <div class="service-price">
                    <?php if ($service->getPrixService() > 0):
                        echo number_format($service->getPrixService(), 2); ?> €
                    <?php else:
                        echo "gratuit";
                    endif;
                    ?>
                </div>
                <div class="service-price"><?php echo $service->getTypeService(); ?></div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<br>

<div class="btn">
    <a href="../web/controleurFrontal.php?controleur=service&action=afficherFormulaireProposerService" class="btn new-service-btn">Nouveau</a>
</div>