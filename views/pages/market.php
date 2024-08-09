<section class="market">
    <div>
        <h1 class="playfair-font">Nos livres à l'échange</h1>
        <form action="index.php?action=market" method="POST">
            <input type="search" name="search" placeholder="Rechercher un livre" class="search_bar">
            <button type="submit" class="hidden"></button>
        </form>

    </div>
    <div class="cards-container">
        <?php
        foreach ($datas as $entry) {
            $book = $entry["book"];
            $user = $entry["user"];

            ?>
            <a href="index.php?action=detailBook&idBook=<?= $book->getId() ?>" class="book_card">
                <figure>
                    <img src=<?= $book ? Utils::filepath($book->getFilename()) : null ?> alt="<?= ($book && $book->getFilename()) ? 'Couverture du livre' : '' ?>" width="200" height="200">
                    <figcaption>
                        <h3><?= $book->getTitle() ?></h3>
                        <h4><?= $book->getAuthor() ?></h4>
                        <p>Vendu par : <?= $user->getUsername() ?></p>
                    </figcaption>
                </figure>
            </a>
            <?php
        }
        ?>
    </div>
</section>