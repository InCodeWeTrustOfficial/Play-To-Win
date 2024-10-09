<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../ressources/css/css_minimaliste.css">
    <meta charset="UTF-8">
    <title>
        <?php
        /** @var string $titre */
        echo $titre; ?></title>
</head>
<body>
<header>
    <nav>
        <ul>
            <?php

            ?>
            <li>
                <a href="controleurFrontal.php?action=afficherListe&controleur=utilisateur">Gestion des utilisateurs</a>
            </li><li>
                <a href="controleurFrontal.php?action=afficherListe&controleur=trajet">Gestion des trajets</a>
            </li>
        </ul>
    </nav>


</header>
<main>
    <?php
    /** @var string $cheminCorpsVue */
    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <p>
        Site de covoiturage du PNJ
    </p>
</footer>
</body>
</html>

