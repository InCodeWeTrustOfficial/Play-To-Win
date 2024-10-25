<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../ressources/css/css_minimaliste.css">
    <link rel="stylesheet" href="../ressources/css/navstyles.css">
    <link rel="stylesheet" href="../ressources/css/service.css">
    <link rel="stylesheet" href="../ressources/css/coach.css">
    <meta charset="UTF-8">
    <title>
        <?php
        /** @var string $titre */

        use App\PlayToWin\Lib\ConnexionUtilisateur;

        echo $titre; ?></title>
</head>
<body>
<header>
    <nav>
        <ul>
            <?php

            ?>
            <li>
                <a href="controleurFrontal.php?action=afficherListe&controleur=coach">Coaching</a>
            </li>
            <li>
                <a href="controleurFrontal.php?action=afficherListe&controleur=utilisateur">Gestion des utilisateurs</a>
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
                $ids = ConnexionUtilisateur::getIdUtilisateurConnecte();
                $idURL = rawurlencode($ids);
                echo '
                <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherDetail&id='.$idURL.'"><img src="../ressources/img/user.png "></a>
            </li>
            <li>
                <a href="controleurFrontal.php?controleur=utilisateur&action=deconnecter"><img src="../ressources/img/logout.png"></a>
            </li>
            <li>
                <a href="controleurFrontal.php?controleur=service&action=afficherListe"><img src="../ressources/img/produit.png"></a>
            </li>
                ';
            }
            ?>
        </ul>
    </nav>
    <div>
        <?php
        /** @var string[][] $messagesFlash */
        foreach($messagesFlash as $type => $messagesFlashPourUnType) {
            // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
            // $messagesFlashPourUnType est la liste des messages flash d'un type
            foreach ($messagesFlashPourUnType as $messageFlash) {
                echo <<< HTML
            <div class="alert alert-$type">
               $messageFlash
            </div>
            HTML;
            }
        }
        ?>
    </div>
</header>
<main>
    <?php
    /** @var string $cheminCorpsVue */
    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <p>
        PlayToWin, site de e-commerce
    </p>
</footer>
</body>
</html>

