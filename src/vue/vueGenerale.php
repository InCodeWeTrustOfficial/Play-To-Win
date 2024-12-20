<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../ressources/img/icone/play-to-win-logo.png" type="image/png">
    <link rel="stylesheet" href="../ressources/css/nav_bar.css">
    <link rel="stylesheet" href="../ressources/css/background.css">
    <link rel="stylesheet" href="../ressources/css/footer.css">
    <link rel="stylesheet" href="../ressources/css/formulaires.css">
    <link rel="stylesheet" href="../ressources/css/navstyles.css">
    <link rel="stylesheet" href="../ressources/css/service.css">
    <link rel="stylesheet" href="../ressources/css/coach.css">
    <link rel="stylesheet" href="../ressources/css/panier.css">
    <link rel="stylesheet" href="../ressources/css/commande.css">
    <link rel="stylesheet" href="../ressources/css/exemplaire.css">
    <link rel="stylesheet" href="../ressources/css/jeux.css">
    <link rel="stylesheet" href="../ressources/css/utilisateur.css">
    <link rel="stylesheet" href="../ressources/css/admin.css">
    <title>
        <?php
        /** @var string $titre */
        echo $titre; ?>
    </title>
</head>
<body>
<header>
    <nav class="navbar">
        <a href="controleurFrontal.php" class="logo-link">
            <img src="../ressources/img/icone/play-to-win-logo.png" alt="Logo">
            Play To Win
        </a>

        <div class="nav-center">
            <a href="controleurFrontal.php?controleur=jeux" class="nav-link">
                <img src="../ressources/img/icone/home.png" alt="Home">
                Home
            </a>
            <a href="controleurFrontal.php?controleur=coach&action=afficherListe" class="nav-link">
                <img src="../ressources/img/icone/coaching.png" alt="Coaching">
                Coaching
            </a>
            <?php
            /** @var boolean $estAdmin */
            /** @var boolean $estCoach */
            if($estAdmin){
                echo '
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle">Administrateur</a>
                    <div class="dropdown-menu">
                        <a href="controleurFrontal.php?controleur=administrateur&action=afficherListeServices" class="dropdown-item">Services</a>
                        <a href="controleurFrontal.php?controleur=administrateur&action=afficherListeCoachs" class="dropdown-item">Coachs</a>
                        <a href="controleurFrontal.php?controleur=administrateur&action=afficherListeUtilisateurs" class="dropdown-item">Utilisateurs</a>
                    </div>
                </div>
                ';
            }
            ?>
        </div>
        <div class="nav-right">

            <a href="controleurFrontal.php?controleur=generique&action=afficherFormulairePreference" class="icon-link">
                <img src="../ressources/img/icone/heart.png" alt="Preference">
            </a>

            <a href="controleurFrontal.php?controleur=service&action=afficherPanier" class="icon-link">
                <img src="../ressources/img/icone/panier.png" alt="Panier">
            </a>

            <?php
            /** @var boolean $estConnecte */
            if (!$estConnecte) {
                echo '
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion" class="login-button">
                    Se connecter
                </a>
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireCreation" class="login-button">
                    Créer un compte
                </a>
                ';
            } else {
                /** @var string $idUtilisateur */
                /** @var string $idURL */
                echo '
                <div class="user-icons">
                    <a href="controleurFrontal.php?controleur=commande&action=afficherListe" class="icon-link">
                        <img src="../ressources/img/icone/commande.png" alt="Commande">
                    </a>
                   ';

                if($estAdmin || $estCoach ) {
                    echo '
                    <a href="controleurFrontal.php?controleur=service&action=afficherListe&id=' . $idURL . '" class="icon-link">
                        <img src="../ressources/img/icone/produit.png" alt="Service">
                    </a>';
                }

                echo '
                    <a href="controleurFrontal.php?controleur=utilisateur&action=afficherDetail&id='.$idURL.'" class="icon-link">
                        <img src="../ressources/img/icone/user.png" alt="User">
                    </a>
                    <a href="controleurFrontal.php?controleur=utilisateur&action=deconnecter" class="icon-link">
                        <img src="../ressources/img/icone/logout.png" alt="Logout">
                    </a>
                </div>';
            }
            ?>
        </div>
    </nav>
    <div>
        <?php
        /** @var string[][] $messagesFlash */
        foreach($messagesFlash as $type => $messagesFlashPourUnType) {
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
    <div class="footer-content">
        <div class="footer-section">
            <h3>À propos de nous</h3>
            <ul>
                <li><a href="#">Qui sommes-nous</a></li>
                <li><a href="#">Notre équipe</a></li>
                <li><a href="#">Nos services</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Contact</h3>
            <ul>
                <li><a href="#">Support client</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Nous contacter</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Suivez-nous</h3>
            <div class="social-links">
                <a href="#" class="social-icon">
                    <img src="../ressources/img/icone/x.png" alt="X">
                </a>
                <a href="#" class="social-icon">
                    <img src="../ressources/img/icone/discord.png" alt="Discord">
                </a>
                <a href="#" class="social-icon">
                    <img src="../ressources/img/icone/instagram.png" alt="Instagram">
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>PlayToWin © 2024 - Tous droits réservés</p>
    </div>
</footer>
</body>
</html>