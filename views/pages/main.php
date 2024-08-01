<?php
$conversationController = new conversationController();
$unreadMessageCount = $conversationController->countUnreadMessage();
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
                <a href="index.php?action=home">Accueil</a>
                <a href="index.php?action=market" class="font-bold">Nos livres à l'échange</a>
            </div>
            <div class="headerMenu">
                <?php
                if (isset($_SESSION['user'])) {
                    ?>
                    <div>
                        <a href="index.php?action=mailbox">Messagerie
                            <?= '(' . $unreadMessageCount . ')' ?></a>
                        <a href="index.php?action=myProfile">Mon compte</a>
                        <a href="index.php?action=logout">Déconnexion</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div>
                        <a href="index.php?action=connexion">Connexion</a>
                        <a href="index.php?action=inscription">Inscription</a>
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