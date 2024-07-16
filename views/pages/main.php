<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomTroc</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <header>
        <nav>
            <?php
            // Si on est connecté, on affiche le bouton de déconnexion, sinon, on affiche le bouton de connexion : 
            if (isset($_SESSION['user'])) {
                echo '<a href="index.php?action=disconnectUser">Déconnexion</a>';
            }
            ?>

            <a href="index.php?action=editBook">Ajouter un livre.</a>
        </nav>
        <h1>TomTroc</h1>
    </header>
    <main>
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer>
        <p>TomTroc - 2021</p>
    </footer>

</body>

</html>