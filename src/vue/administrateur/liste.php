<?php
use App\PlayToWin\Lib\ConnexionUtilisateur;
use App\PlayToWin\Modele\DataObject\ObjetListable;

/** @var ObjetListable[] $objets */
/** @var string $controleur */
?>

<div class="admin-container">
    <div class="admin-list">
        <div class="admin-list-header">
            <h2>Liste des <?= htmlspecialchars(ucfirst($controleur)) ?>s</h2>
        </div>

        <table class="admin-table">
            <thead>
            <tr>
                <?php
                foreach ($objets[0]->getNomColonnes() as $colonne) {
                    echo "<th>" . htmlspecialchars($colonne) . "</th>";
                }
                ?>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($objets as $objet):
                $idURL = rawurlencode($objet->getId());
                $elements = $objet->getElementColonnes();
                ?>

                <tr>
                    <?php foreach ($elements as $element): ?>
                        <td class="admin-list-text">
                            <?php if ($element === $objet->getId()): ?>
                                <a class="admin-list-id" href="../web/controleurFrontal.php?controleur=<?= $controleur ?>&action=afficherDetail&id=<?= $idURL ?>">
                                    <?= htmlspecialchars($element) ?>
                                </a>
                            <?php else: ?>
                                <?= htmlspecialchars($element) ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>

                    <td class="admin-actions">
                        <?php if (ConnexionUtilisateur::estAdministrateur()): ?>
                            <a href="../web/controleurFrontal.php?controleur=<?= $objet->getControleur() ?>&action=afficherFormulaireMiseAJour&id=<?= $idURL ?>"
                               class="admin-btn admin-btn-edit">
                                Modifier
                            </a>
                            <a href="../web/controleurFrontal.php?controleur=<?= $objet->getControleur() ?>&action=supprimer&id=<?= $idURL ?>"
                               class="admin-btn admin-btn-delete">
                                Supprimer
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="admin-create-section">
        <?php if($controleur == "coach"): ?>
            <a href="../web/controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireCreation" class="admin-create-btn">
                Créer un nouvel utilisateur
            </a>
        <?php else: ?>
            <a href="../web/controleurFrontal.php?controleur=<?= $controleur ?>&action=afficherFormulaireCreation" class="admin-create-btn">
                Créer un nouveau <?= htmlspecialchars(ucfirst($controleur)) ?>
            </a>
        <?php endif; ?>
    </div>
</div>