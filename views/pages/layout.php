<?php

$conversationController = new ConversationController();
$unreadMessageCount = $conversationController->countUnreadMessage();
$action = isset($_GET['action']) ? $_GET['action'] : null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Playfair+Display:ital@0;1&display=swap"
            rel="stylesheet">
</head>

<body>
<header>
    <nav>
        <img src="./assets/logo.svg" alt="Logo TomTroc">
        <div>
            <a href="index.php?action=home" <?= ($action === 'home' || $action === null) ? 'class="font-semibold"' : null ?>>Accueil</a>
            <a href="index.php?action=market" <?= ($action === 'market') ? 'class="font-semibold"' : null ?>>Nos livres
                à l'échange</a>
        </div>
        <div class="headerMenu">
            <?php
            if (isset($_SESSION['user'])) {
                ?>
                <div>
                    <a data-count="<?= $unreadMessageCount ?>"
                       href="index.php?action=mailbox" <?= ($action === 'mailbox') ? 'class="font-semibold unreadCount"' : 'class="unreadCount"' ?>>
                        <img src="./assets/messagerie_icon.svg" alt="" width="15" height="13">
                        Messagerie
                    </a>
                    <a href="index.php?action=myProfile" <?= ($action === 'myProfile') ? 'class="font-semibold"' : null ?>>
                        <img src="./assets/my_account.svg" alt="" width="10" height="13">
                        Mon compte
                    </a>
                    <a href="index.php?action=logout">Déconnexion</a>
                </div>
                <?php
            } else {
                ?>
                <div>
                    <a href="index.php?action=connexion" <?= ($action === 'connexion') ? 'class="font-semibold"' : null ?>>Connexion</a>
                    <a href="index.php?action=inscription" <?= ($action === 'inscription') ? 'class="font-semibold"' : null ?>>Inscription</a>
                </div>
                <?php
            }
            ?>
        </div>
    </nav>
</header>
<main>
    <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
</main>

<footer class="font-light">
    <a href="#">Politique de confidentialité</a>
    <a href="#">Mentions légales</a>
    <a href="#">Tom Troc&copy;</a>
    <img src="./assets/tt.svg" alt="">
</footer>

<script src="./app.js"></script>
</body>

</html>