<?php
$link = $book ? 'index.php?action=editBook&id=' . $book->getId() : 'index.php?action=createBook';
?>
<section class="create_edit_book">
    <div>
        <a href="index.php?action=myProfile"><- retour</a>
                <h1 class="playfair-font"><?= $book ? "Modifier les informations" : "Créer un nouveau livre" ?></h1>
    </div>
    <div class="container">
        <figure>
            <img src=<?= Utils::filepath($book ? $book->getFilename() : null)?> alt=<?= ($book && $book->getFilename()) ? "Couverture du livre" : "Pas d'illustration" ?>>
            <figcaption>
                <label for="image" class="underline">Modifier la photo</label>
            </figcaption>
        </figure>
        <form method="POST" enctype="multipart/form-data" action=<?= $link ?>>
            <label>
                Titre du livre
                <input type="text" name="title" placeholder="Titre du livre" value=<?= $book ? $book->getTitle() : "" ?>>
            </label>
            <label>
                Auteur
                <input type="text" name="author" placeholder="Auteur du livre." value=<?= $book ? $book->getAuthor() : "" ?>>
            </label>
            <label>
                Commentaire
                <textarea name="description"
                    placeholder="Description"><?= $book ? $book->getDescription() : null ?></textarea>
            </label>
            <label>
                Disponibilité
                <select name="availability">
                    <option value="1" <?= ($book && $book->getAvailability()) == 1 ? "selected" : null ?>>Disponible
                    </option>
                    <option value="0" <?= ($book && $book->getAvailability()) == 0 ? "selected" : null ?>>Indisponible
                    </option>
                </select>
            </label>

            <input type="file" name="file" id="image" class="hidden" accept="image/*">

            <button type="submit"
                class="primary_button primary_button--long font-semibold"><?= $book ? "Valider" : "Ajouter" ?></button>
        </form>
    </div>
</section>