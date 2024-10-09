<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../ressources/css/style.css">
    <meta charset="UTF-8">
    <title>
        <?php
        /** @var string $titre */
        echo $titre; ?></title>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo"> <a href="controleurFrontal.php?controleur=accueil">Play to Win</a> </div>
        <ul class="nav-links">
            <li><a href="controleurFrontal.php?controleur=accueil">Accueil</a></li>
            <li><a href="controleurFrontal.php?action=afficherListe&controleur=coach">Coach</a></li>
            <li><a href="controleurFrontal.php?controleur=contact">Contact</a></li>
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

