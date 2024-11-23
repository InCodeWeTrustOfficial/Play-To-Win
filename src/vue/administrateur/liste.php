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
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($objets as $objet):
                $idHTML = htmlspecialchars($objet->getId());
                $idURL = rawurlencode($objet->getId());
                $nomHTML = htmlspecialchars($objet->getNom());
                $nomURL = rawurlencode($objet->getNom());

                ?>
                <tr>
                    <td>
                        <a class="admin-list-text" href="../web/controleurFrontal.php?controleur=<?= $controleur ?>&action=afficherDetail&id=<?= $idURL ?>">
                            <?= $idHTML ?>
                        </a>
                    </td>
                    <td class="admin-list-text">
                        <?= $nomHTML ?>
                    </td>
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