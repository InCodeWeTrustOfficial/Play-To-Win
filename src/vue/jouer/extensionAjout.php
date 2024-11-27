<?php

use App\PlayToWin\Modele\DataObject\ClassementJeu;
use App\PlayToWin\Modele\DataObject\Jeu;
use App\PlayToWin\Modele\DataObject\ModeDeJeu;

/** @var Jeu[] $jeux */
/** @var array $modesDunJeu */
/** @var array $classementsPossibles */
/** @var string $idUser */
/** @var Jeu $jeu */
/** @var ModeDeJeu[] $md */
?>
<p class="InputAddOn">
    <label class="InputAddOn-item" for="mode_id">Mode</label>
    <select name="mode" id="mode_id">
        <?php

        echo '<option value="rien" selected="selected">Mode...?</option>';

        foreach ($md as $mode) {
            echo '<option value="' . $mode->getNomMode() . '">' . htmlspecialchars($mode->getNomMode()) . '</option>';
        }
        ?>
    </select>
</p>
<?php
require_once 'extClassement.php';
?>
