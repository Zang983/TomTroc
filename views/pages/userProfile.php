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
            <?php if (!$ownerAccount) {
                ?>
                <a href="index.php?action=openChat&idReceiver=<?= $user ? $user->getId() : null ?>"
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
    <div class="account_librairy<?= !$ownerAccount ? ' account_librairy--smaller' : '' ?>">
        <div class="account_librairy_titles">
            <div class="account_librairy_titles--firstCol">Photo</div>
            <div class="account_librairy_titles--title">Titre</div>
            <div  class="account_librairy_titles--author">Auteur</div>
            <div  class="account_librairy_titles--description">Description</div>
            <div  class="account_librairy_titles--availability">Disponibilité</div>
            <div class="account_librairy_titles--lastCol">Action
                <!-- <a href="index.php?action=newBookForm">+</a> -->
            </div>
        </div>
        <div class="account_librairy_entry">
            <div class="account_librairy_entry--firstCol"><img src="./uploads/books/1722268727_test_image2.webp"
                    alt="Couverture du livre" width="78" height="78"></div>
            <div class="account_librairy_entry--title">Titre</div>
            <div class="account_librairy_entry--author">Jules Vernes</div>
            <div class="account_librairy_entry--description">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, consequuntur, est eos laborum
                consectetur aliquid deserunt adipisci atque saepe libero nemo assumenda placeat perspiciatis fuga in
                fugiat ab consequatur corporis!
                Doloremque sint minus excepturi harum iste. Iste ipsa quo magnam, reprehenderit illo natus incidunt.
                Sint vitae nihil quasi totam voluptates sed, ullam optio? Fugit tempore qui, aliquam neque natus
                doloribus.
                Perferendis, assumenda? Cum numquam reprehenderit sed expedita adipisci itaque dicta rerum voluptatibus
                dolorem placeat quisquam, nesciunt debitis omnis distinctio sint dolorum libero vel maiores fugit. Sint
                eaque fugit itaque obcaecati.
                Incidunt illum tenetur ipsa molestiae delectus, voluptas iste ut minima officia repellendus quasi, iusto
                vitae consequatur sunt reiciendis aliquam deserunt ipsum accusantium obcaecati voluptates. Similique
                sunt porro voluptatibus tempora iusto!</div>
            <div class="account_librairy_entry--availability">Disponible</div>
            <div class="account_librairy_entry--lastCol account_librairy_entry--action">
            <a href="index.php?action=editBookForm&id=1">Éditer</a>
                <a href="index.php?action=deleteBook&id=1">Supprimer</a>
            </div>
        </div>
</section>