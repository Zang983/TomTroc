<section class="connexion">
    <form method="POST"
          action='index.php?action=<?= $_GET["action"] === "inscription" ? "createUser" : "connectUser" ?>'>
        <h1 class="playfair-font">
            <?= $_GET["action"] === "inscription" ? "Inscription" : "Connexion" ?>
        </h1>
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
        <button type="submit"
                class="primary_button primary_button--full_width font-semibold"><?= $_GET["action"] === "inscription" ? "S'inscrire" : "Se connecter" ?></button>
        <?php
        if ($_GET["action"] === "inscription") { ?>
            <p>Pas de compte ? <a href="index.php?action=connexion" class="underline">Connectez-vous</a></p>
            <?php
        } else { ?>
            <p>Déjà inscrit ? <a href="index.php?action=inscription" class="underline">Inscrivez-vous</a></p>

            <?php
        } ?>
    </form>


    <img src="assets/connexion.png" alt="">
</section>