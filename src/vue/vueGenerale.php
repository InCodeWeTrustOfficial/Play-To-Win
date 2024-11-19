<!DOCTYPE html>
<html lang="fr">
<head>
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
    <script src="../ressources/scripts/service.js" defer></script>
    <meta charset="UTF-8">
    <title>
        <?php
        /** @var string $titre */
        use App\PlayToWin\Lib\ConnexionUtilisateur;
        echo $titre; ?>
    </title>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="nav-center">
            <a href="controleurFrontal.php" class="nav-link">
                <img src="../ressources/img/icone/home.png" alt="Home">
                Home
            </a>
            <a href="controleurFrontal.php?controleur=coach&action=afficherListe" class="nav-link">
                <img src="../ressources/img/icone/coaching.png" alt="Coaching">
                Coaching
            </a>
            <?php
            $estAdmin = ConnexionUtilisateur::estAdministrateur();
            if($estAdmin){
                echo '
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherListe" class="nav-link">
                    Administrateur
                </a>
                ';
            }
            ?>
        </div>
        <div class="nav-right">
            <?php
            if (!ConnexionUtilisateur::estConnecte()) {
                echo '
                <a href="controleurFrontal.php?controleur=utilisateur&action=afficherFormulaireConnexion" class="login-button">
                    Se connecter
                </a>';
            } else {
                $ids = ConnexionUtilisateur::getIdUtilisateurConnecte();
                $idURL = rawurlencode($ids);
                echo '
                <div class="user-icons">
                    <a href="controleurFrontal.php?controleur=commande&action=afficherListe" class="login-button">
                        Commande
                    </a>
                    <a href="controleurFrontal.php?controleur=service&action=afficherPanier" class="icon-link">
                        <img src="../ressources/img/icone/panier.png" alt="Panier">
                    </a>';


                echo '
                    <a href="controleurFrontal.php?controleur=service&action=afficherListe&id='.$idURL.'" class="icon-link">
                        <img src="../ressources/img/icone/produit.png" alt="Service">
                    </a>';

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
            <h3>Services</h3>
            <ul>
                <li><a href="#">Coaching</a></li>
                <li><a href="#">Formations</a></li>
                <li><a href="#">Support</a></li>
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
                    <img src="../ressources/img/icone/X.png" alt="X">
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