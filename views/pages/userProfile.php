<?php
$ownerAccount = ($user->getId() === $_SESSION['user']->getId() && $_GET['action'] === 'myProfile');// We check if user is the owner of the account to display the edit form.
?>
<section class="profile<?= !$ownerAccount ? ' profile--public' : '' ?>">
    <?= $ownerAccount ? "<h1 class='playfair-font'>Mon compte</h1>" : "" ?>
    <section class="account_detail<?= !$ownerAccount ? ' account_detail--smaller' : '' ?>">
        <div>
            <img src=<?= $user ? Utils::filepath($user->getAvatar(),true):null ?> alt="avatar" class="avatar" height="135" width="135">
            <?php
            if ($ownerAccount) {
                ?>
                <label class="underline" for="avatarInput">modifier</label>
                <?php
            }
            ?>

            <hr />
            <h2 class="playfair-font"><?= $user->getUsername() ?></h2>
            <p>Inscrit depuis : <?= Utils::getRegistrationDuration($user->getCreatedAt())?></p>
            <div>
                <h3>Bibliothèque</h3>
                <p><?= count($library) ?> livres</p>
            </div>
        </div>
        <?php
        if ($ownerAccount) { ?>
            <form method="POST" enctype="multipart/form-data" class="edit_profile_form" action="index.php?action=updateUser">
                <h2>Vos informations personnelles</h2>
                <label>
                    Adresse email
                    <input type="text" name="email" placeholder="<?= $user->getEmail() ?>">
                </label>
                <label>
                    Mot de passe
                    <input type="password" placeholder="Votre nouveau mot de passe" name="password" value="" autocomplete="off">
                </label>
                <label>
                    Pseudo
                    <input type="text" name="username" placeholder="<?= $user->getUsername() ?>" autocomplete="off">
                </label>
                <input type="file" id="avatarInput" class="hidden" name="file" accept="image/png, image/jpeg">
                <button type="submit" class="secondary_button font-semibold">Enregistrer</button>
            </form>
            <?php
        } ?>
    </section>

    <section class="account_librairy<?= !$ownerAccount ? ' account_librairy--smaller' : '' ?>">
        <a href="index.php?action=newBookForm">Ajouter un livre.</a>
        <div class="first_line">
            <div>Photo</div>
            <div>Titre</div>
            <div>Auteur</div>
            <div>Description</div>
            <div>Disponibilité</div>
            <div>Action</div>
        </div>
        <?php
        foreach ($library as $book) {
            ?>
            <div class="book_row">
                <img src=<?= $book ? Utils::filepath($book->getFilename()):null ?> alt="book cover" width="78" height="78">
                <h2><?= $book->getTitle() ?></h2>
                <h2><?= $book->getAuthor() ?></h2>
                <p><?= $book->getDescription() ?></p>
                <p><?= $book->getAvailability() === 1 ? 'Disponible' : 'Indisponible' ?></p>
                <div>
                    <a href="index.php?action=deleteBook&id=<?= $book->getId() ?>">Supprimer</a>
                    <a href="index.php?action=editBookForm&id=<?= $book->getId() ?>">Éditer</a>
                </div>
            </div>
            <?php
        }
        ?>
    </section>

</section>