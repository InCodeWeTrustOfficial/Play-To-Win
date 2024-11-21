<?php
use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\DataObject\Jeu;

/** @var array $classementsPossibles */
/** @var Jeu $jeu */
?>

<p class="InputAddOn">
    <label class="InputAddOn-item" for="class_id">Classement</label>
    <select name="class" id="class_id">
        <?php

        echo '<option value="rien" selected="selected">Classement...?</option>';

        $class = $classementsPossibles[$jeu->getCodeJeu()];

        foreach ($class as $cl) {
            /** @var ClassementJeu $cl */
            echo '<option value="' . $cl->getClassement()->getIdClassement() . '">' . htmlspecialchars($cl->getClassement()->getNomClassement()) . '</option>';
        }
        ?>
    </select>
</p>
