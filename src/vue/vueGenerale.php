<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../ressources/css/css_minimaliste.css">
    <meta charset="UTF-8">
    <title>
        <?php
        /** @var string $titre */

        use App\Covoiturage\Lib\ConnexionUtilisateur;

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
            </li><li>
                <a href="controleurFrontal.php?action=afficherFormulairePreference"><img src="../ressources/img/heart.png"></a>
            </li>
            <?php
            if (!ConnexionUtilisateur::estConnecte()){
                echo '
                <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireCreation"><img src="../ressources/img/add-user.png"></a>
            </li><li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion"><img src="../ressources/img/enter.png"></a>
            </li>
                ';
            } else{
                $logins = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                $loginURL = rawurlencode($logins);
                echo '
                <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherDetail&login='.$loginURL.'"><img src="../ressources/img/user.png"></a>
            </li>
            <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=deconnecter"><img src="../ressources/img/logout.png"></a>
            </li>
            <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=proposerService"><img src="../ressources/img/produit.png"></a>
            </li>
                ';
            }
            ?>
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

