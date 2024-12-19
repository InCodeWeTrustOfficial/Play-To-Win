<div class="contenu">
    <div class="texte">
        <h2>Besoin d'un <span id="coaching">coaching</span> ?</h2>
        <p>Découvre la sélection de jeux que nous te proposons afin de te rendre davantage compétitif dans les modes
            classés !</p>
    </div>
    <div class="separator"></div>

    <?php

    use App\PlayToWin\Modele\DataObject\Jeu;

    /** @var Jeu[] $jeux */
    ?>
    <div class="conteneur-jeux">
        <?php
        foreach ($jeux as $jeu) {
            echo '<div class="jeu-carte">';
            echo '<a href="../web/controleurFrontal.php?controleur=coach&action=afficherListe&jeu='.rawurlencode($jeu->getCodeJeu()).'"><img class="jeux" src="../' . $jeu->getPathLogo() . '" alt="icon">';
            echo '<p>' .htmlspecialchars($jeu->getNomJeu()) . '</p></a>';
            echo '</div>';
        }
        ?>
    </div>
</div>
