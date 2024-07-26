<section class="home">
    <div>
        <h1 class="playfair-font">Rejoignez nos lecteurs passionnés</h1>
        <p class="font-light">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la
            lecteur. Nous croyons en
            la
            magie du partage de connaissances et d'histoires à travers les livres.</p>
        <a href="#" class="primary_button font-semibold">Découvrir</a>
    </div>
    <figure>
        <img src="./assets/hamza-nouasria.png" alt="Photo de Hamza">
        <figcaption>
            Hamza
        </figcaption>
    </figure>
</section>
<section class="lastBooks">
    <h2 class="playfair-font">Les derniers livres ajoutés</h2>
    <div>
        <?php
        foreach ($datas as $entry) {
            $book = $entry['book'];
            $user = $entry['user'];
            ?>
            <a class="book_card" href="index.php?action=detailBook&idBook=<?=$book->getId() ?>">
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
    <a href="index.php?action=market" class="primary_button font-semibold">
        Voir tous les livres
    </a>
</section>
<section class="how_steps">
    <h2 class="playfair-font">Comment ça marche ? </h2>
    <p class="font-light">Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour
        commencer : </p>
    <div class="cards-container">
        <p class="how_steps--cards">
            Inscrivez-vous gratuitement sur notre plateforme.
        </p>
        <p class="how_steps--cards">
            Ajoutez les livres que vous souhaitez échanger à votre profil.
        </p>
        <p class="how_steps--cards">
            Parcourez les livres disponibles chez d'autres membres.
        </p>
        <p class="how_steps--cards">
            Proposez un échange et discutez avec d'autres passionnés de lecture.
        </p>
    </div>
    <a href="index.php?action=market" class="primary_button font-semibold primary_button--reversed">Voir tous les
        livres</a>
</section>
<section class="our_values">
    <img src="./assets/home_banner.png" alt="Bannière accueil" class="home_banner" height="230">
    <blockquote>
        <h2 class="playfair-font">Nos valeurs</h2>
        <p class="font-light">
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont
            ancrées
            dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs.Nous croyons en la
            puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
        </p>
        <p class="font-light">
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
        </p>
        <p class="font-light">
            Nous sommes passionés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter,
            de
            partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </p>
        <cite>L'équipe Tom Troc</cite>
        <img src="./assets/sign_heart.svg" alt="" width="120" height="102">
    </blockquote>


</section>