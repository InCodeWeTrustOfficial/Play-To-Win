<?php

use App\PlayToWin\Modele\DataObject\ExemplaireService;

/** @var ExemplaireService[] $exemplaireservices */
/** @var string $controleur  */
?>

<div class="exemplaireservice-container">
    <h2 class="exemplaireservice-title">Liste des exemplaires de service</h2>

    <?php if (empty($exemplaireservices)): ?>
        <div class="no-exemplaireservice">
            Aucun exemplaire de service n'a été commandé pour le moment.
        </div>
    <?php else: ?>
        <?php foreach ($exemplaireservices as $exemplaireservice): ?>
            <a class="exemplaireservice-link" href="../web/controleurFrontal.php?controleur=exemplaireservice&action=afficherDetails&codeService=<?= htmlspecialchars($exemplaireservice->getCodeService()) ?>">
                <div class="exemplaireservice-card">
                    <div class="exemplaireservice-subject">
                        <?= htmlspecialchars($exemplaireservice->getSujet()) ?>
                    </div>
                    <div class="exemplaireservice-status status-<?= strtolower(str_replace(' ', '-', $exemplaireservice->getEtatService())) ?>">
                        <?= htmlspecialchars($exemplaireservice->getEtatService()) ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>