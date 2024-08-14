<section class="detail_book">
    <a href="index.php?action=market" class="font-light">Nos livres > <?= $book ? $book->getTitle() : null ?></a>
    <figure>
        <img src=<?= $book ? Utils::filepath($book->getFilename()) : null ?> alt="livre">
        <figcaption>
            <h1 class="playfair-font"><?= $book ? $book->getTitle() : null ?></h1>
            <h2>par <?= $book ? $book->getAuthor() : null ?></h2>
            <hr>
            <h3 class="font-semibold">Description</h3>
            <blockquote>
                <?= $book ? $book->getDescription() : null ?>
            </blockquote>

            <div class="owner">

                <h4 class="font-semibold">Propriétaire</h4>
                <div>
                    <a href="index.php?action=profile&id=<?= $user ? $user->getId() : null ?>" class="owner_card">
                        <img src=<?= $book ? Utils::filepath($user->getAvatar(), true) : null ?> alt="avatar" width="48"
                             height="48">
                        <p><?= $user ? $user->getUsername() : null ?></p>
                    </a>
                </div>

            </div>
            <?php
            if (isset($_SESSION['user'])) {
                ?>
                <a href="index.php?action=mailbox&idReceiver=<?= $user ? $user->getId() : null ?>"
                   class="primary_button primary_button--full_width font-semibold">Envoyer un message</a>
                <button id="modale_opener" class="hidden primary_button primary_button--full_width font-semibold">
                    Envoyer un
                    message
                </button>
                <dialog>
                    <div class="dialog_container">
                        <button id="modale_closer" class="close_button">X</button>
                        <form action="index.php?action=sendMessageWithAjax" method="dialog">
                            <label for="message">Envoyer un message à <?= $user ? $user->getUsername() : null ?></label>
                            <textarea autofocus name="message" id="message" cols="30" rows="10"></textarea>
                            <button data-idReceiver=<?= $user ? $user->getId() : null ?>
                                    class="primary_button primary_button--full_width font-semibold
                            ">Confirmation</button>
                        </form>
                    </div>
                </dialog>
                <?php
            }
            ?>
        </figcaption>
    </figure>

</section>