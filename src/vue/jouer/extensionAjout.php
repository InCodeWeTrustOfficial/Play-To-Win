<?php

use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\DataObject\Jeu;

/** @var Jeu[] $jeux */
/** @var array $modesDunJeu */
/** @var array $classementsPossibles */
/** @var string $idUser */
/** @var Jeu $jeu */
?>
<p class="InputAddOn">
    <label class="InputAddOn-item" for="mode_id">Mode</label>
    <select name="mode" id="mode_id" required>
        <?php

        echo '<option value="rien" selected="true">Mode...?</option>';

        $md = $modesDunJeu[$jeu->getCodeJeu()];

        foreach ($md as $mode) {
            echo '<option value="' . $mode->getNomMode() . '">' . $mode->getNomMode() . '</option>';
        }
        ?>
    </select>
</p>
<p class="InputAddOn">
    <label class="InputAddOn-item" for="class_id">Classement</label>
    <select name="class" id="class_id" required>
        <?php

        echo '<option value="rien" selected="true">Classement...?</option>';

        $class = $classementsPossibles[$jeu->getCodeJeu()];

        foreach ($class as $cl) {
            /** @var ClassementJeu $cl */
            echo '<option value="' . $cl->getClassement()->getIdClassement() . '">' . $cl->getClassement()->getNomClassement() . '</option>';
        }
        ?>
    </select>
</p>
