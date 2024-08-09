<?php
$ownerAccount = $_GET['action'] === 'myProfile';// Check if it's the owner account if we want to display all informations with both routes (myProfile && profile), actually it's not the case.
?>
<div class="profile<?= !$ownerAccount ? ' profile--public' : '' ?>">
    <?= $ownerAccount ? "<h1 class='playfair-font'>Mon compte</h1>" : "" ?>
    <section class="account_detail<?= !$ownerAccount ? ' account_detail--smaller' : '' ?>">
        <div class="account_detail--fullContainer">
            <img src=<?= $user ? Utils::filepath($user->getAvatar(), true) : null ?> alt="avatar" class="avatar"
                height="135" width="135">
            <?php
            if ($ownerAccount) {
                ?>
                <label class="underline" for="avatarInput">modifier</label>
                <?php
            }
            ?>
            <?= $ownerAccount ? '<hr>' : null ?>
            <h2 class="playfair-font"><?= $user->getUsername() ?></h2>
            <p class="registration_duration">Membre depuis :
                <?= Utils::getRegistrationDuration($user->getCreatedAt()) ?>
            </p>
            <div class="librairy_count">
                <h3 class="font-semibold">Bibliothèque</h3>
                <p>
                    <img src="./assets/librairy_icon.svg" alt="" width="10" height="13">
                    <?= count($library) ?> livres
                </p>
            </div>
            <?php if (!$ownerAccount && isset($_SESSION['user'])) {
                ?>
                <a href="index.php?action=mailbox&idReceiver=<?= $user ? $user->getId() : null ?>"
                    class="secondary_button font-semibold primary_button--full_width font-semibold">
                    Écrire un message
                </a>
                <button id="modale_opener"
                    class="hidden secondary_button font-semibold primary_button--full_width font-semibold">
                    Écrire un message
                </button>
                <dialog>
                    <div class="dialog_container">
                        <button id="modale_closer">X</button>
                        <form action="index.php?action=sendMessageWithAjax" method="dialog">
                            <label for="message">Envoyer un message à <?= $user ? $user->getUsername() : null ?></label>
                            <textarea autofocus name="message" id="message" cols="30" rows="10"></textarea>
                            <button type="submit" data-idReceiver=<?= $user ? $user->getId() : null ?>
                                class="primary_button primary_button--full_width font-semibold">Confirmation</button>
                        </form>
                    </div>
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
    <div class="account_librairy<?= !$ownerAccount ? ' smaller' : '' ?>">
        <div class="account_librairy_titles">
            <div class="account_librairy_titles--firstCol font-semibold">Photo</div>
            <div class="account_librairy_titles--title font-semibold">Titre</div>
            <div class="account_librairy_titles--author font-semibold">Auteur</div>
            <div class="account_librairy_titles--description font-semibold">Description</div>
            <div
                class="account_librairy_titles--availability <?= $ownerAccount ? "account_librairy_titles--lastCol" : null ?> font-semibold">
                Disponibilité</div>
            <?php if ($ownerAccount): ?>
                <div class="account_librairy_titles--lastCol font-semibold">Action
                </div>
                <a href="index.php?action=newBookForm">+</a>
            <?php endif; ?>

        </div>

        <?php
        if (count($library) > 0) {
            foreach ($library as $entry):
                ?>
                <div class="account_librairy_entry">
                    <div class="account_librairy_entry--firstCol"><img src="<?= Utils::filepath($entry->getFilename()) ?>"
                            alt="Couverture du livre" width="78" height="78"></div>
                    <div class="account_librairy_entry--title"><?= $entry->getTitle() ?></div>
                    <div class="account_librairy_entry--author"><?= $entry->getAuthor() ?></div>
                    <div class="account_librairy_entry--description" title="<?= Utils::truncate($entry->getDescription(),100) ?>"><?= $entry->getDescription() ?></div>
                    <div class="account_librairy_entry--availability">
                        <div class="<?= $entry->getAvailability() ? "available" : null ?>">
                            <?= $entry->getAvailability() ? "Disponible" : "Non dispo." ?>
                        </div>
                    </div>
                    <?php if ($ownerAccount): ?>
                        <div class="account_librairy_entry--lastCol account_librairy_entry--action">
                            <a href="index.php?action=editBookForm&id=<?= $entry->getId() ?>" class="edit_link">Éditer</a>
                            <a href="index.php?action=deleteBook&id=<?= $entry->getId() ?>" class="delete_link">Supprimer</a>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach;
            ?>
        </div>
        <?php

        } else {
            if ($ownerAccount)
                echo '<div class="noBooks">Vous n\'avez pas encore ajouté de livre à votre bibliothèque.</div>';
            else
                echo '<div class="noBooks">L\'utilisateur n\'a pas encore ajouté de livre à sa bibliothèque.</div>';

        }
        ?>
</div>