<form method="POST" action='index.php?action=<?= $_GET["action"] === "inscription" ? "createUser" : "connectUser" ?>'>
    <?php
    if ($_GET["action"] === "inscription") { ?>
        <label>
            Nom d'utilisateur :
            <input type="text" name="username" autocomplete="off">
        </label>
    <?php
    }
    ?>

    <label>
        Email
        <input type="text" name="email" autocomplete="username">
    </label>
    <label>
        Mot de passe :
        <input type="password" name="password">
    </label>
    <button type="submit"><?= $_GET["action"] === "inscription" ? "Inscription" : "Connexion" ?></button>

</form>