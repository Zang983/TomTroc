<section class="market">
    <div>
    <h1 class="playfair-font">Nos livres à l'échange</h1>
    <input type="text" placeholder="Rechercher un livre" class="search_bar">
    </div>
    <div class="cards-container">
       <?php
    foreach($datas as $entry){
        $book = $entry["book"];
        $user = $entry["user"];

        ?>
        <a href="index.php?action=detailBook&idBook=<?= $book->getId() ?>" class="book_card">
            <figure>
                <img src=<?= $book ? Utils::filepath($book->getFilename()):null ?> alt="livre" width="200" height="200">
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