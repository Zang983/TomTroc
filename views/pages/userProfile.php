<?php
$ownerAccount = $_GET['action'] === 'myProfile';// Check if it's the owner account if we want to display all informations with both routes (myProfile && profile), actually it's not the case.
?>
<section class="profile<?= !$ownerAccount ? ' profile--public' : '' ?>">
    <?= $ownerAccount ? "<h1 class='playfair-font'>Mon compte</h1>" : "" ?>
    <section class="account_detail<?= !$ownerAccount ? ' account_detail--smaller' : '' ?>">
        <div>
            <img src=<?= $user ? Utils::filepath($user->getAvatar(), true) : null ?> alt="avatar" class="avatar"
                height="135" width="135">
            <?php
            if ($ownerAccount) {
                ?>
                <label class="underline" for="avatarInput">modifier</label>
                <?php
            }
            ?>

            <hr />
            <h2 class="playfair-font"><?= $user->getUsername() ?></h2>
            <p class="registration_duration">Membre depuis : <?= Utils::getRegistrationDuration($user->getCreatedAt()) ?></p>
            <div class="librairy_count">
                <h3 class="font-semibold">Bibliothèque</h3>
                <p>
                    <img src="./assets/librairy_icon.svg" alt="" width="10" height="13">
                    <?= count($library) ?> livres
                </p>
            </div>
            <?php if (!$ownerAccount) {
                ?>
                <a href="index.php?action=openChat&idReceiver=<?= $user ? $user->getId() : null ?>"
                    class="secondary_button font-semibold primary_button--full_width font-semibold">
                    Écrire un message
                </a>
                <button id="modale_opener" class="hidden secondary_button font-semibold primary_button--full_width font-semibold">
                    Écrire un message
                </button>
                <dialog>
                    <div class="dialog_container">
                        <button id="modale_closer">X</button>
                        <form action="index.php?action=sendMessageWithAjax" method="post">
                            <label for="message">Envoyer un message à <?= $user ? $user->getUsername() : null ?></label>
                            <textarea autofocus name="message" id="message" cols="30" rows="10"></textarea>
                            <button type="dialog" data-idReceiver=<?= $user ? $user->getId() : null ?>
                                class="primary_button primary_button--full_width font-semibold">Confirmation</button>
                        </form>
                    </div>
                    </p>
                </dialog>
                <?php
            } ?>

        </div>
        <?php
        if ($ownerAccount) { ?>
            <form method="POST" enctype="multipart/form-data" class="edit_profile_form"
                action="index.php?action=updateUser">
                <h2>Vos informations personnelles</h2>
                <label>
                    Adresse email
                    <input type="text" name="email" placeholder="<?= $user->getEmail() ?>">
                </label>
                <label>
                    Mot de passe
                    <input type="password" placeholder="Votre nouveau mot de passe" name="password" value=""
                        autocomplete="off">
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
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Description</th>
                    <th>Disponibilité</th>
                    <?php if ($ownerAccount) { ?>
                        <th>Action</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($library as $book) { ?>
                    <tr>
                        <td><img src=<?= $book ? Utils::filepath($book->getFilename()) : null ?> alt="book cover" width="78" height="78"></td>
                        <td><?= $book->getTitle() ?></td>
                        <td><?= $book->getAuthor() ?></td>
                        <td><div><?= $book->getDescription() ?></div></td>
                        <td><?= $book->getAvailability() ? 'Disponible' : 'Indisponible' ?></td>
                        <?php if ($ownerAccount) { ?>
                            <td>
                                <a href="index.php?action=deleteBook&id=<?= $book->getId() ?>">Supprimer</a>
                                <a href="index.php?action=editBookForm&id=<?= $book->getId() ?>">Éditer</a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </section>
</section>