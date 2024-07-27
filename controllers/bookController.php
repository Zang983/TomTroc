<?php

class BookController
{

    /* Display methods */
    public function showHome(): void
    {
        $bookManager = new BookManager();
        $datas = $bookManager->getLastBooks();
        $view = new View("Accueil");
        $view->render("home", ["datas" => $datas]);
    }
    public function newBookForm(): void
    {
        $view = new View("Ajouter un livre");
        $view->render("editBook", ["book" => null]);
    }
    public function showEditBookForm(): void
    {
        $bookManager = new BookManager();
        if (!isset($_GET['id'])) {
            throw new Exception("Vous devez spécifier un livre à modifier");
        }
        $book = $bookManager->getBookById($_GET['id']);
        $view = new View("Editer un livre");
        $view->render("editBook", ["book" => $book]);
    }
    public function showMarket(): void
    {
        $bookManager = new BookManager();
        $datas = $bookManager->getAllBooks();
        $view = new View("Livres à l'échange");
        $view->render("market", ["datas" => $datas]);
    }
    public function detailBook(): void
    {
        $bookManager = new BookManager();
        $datas = $bookManager->getBookById($_GET['idBook'], true);
        $book = $datas['book'];
        $user = $datas['user'];
        $view = new View("Détail du livre");
        $view->render("detailBook", ["book" => $book, "user" => $user]);
    }
    /* form processing methods */
    public function updateBook(): void
    {
        if (!isset($_GET['id'])) {
            throw new Exception("Vous devez spécifier un livre à modifier");
        }
        $bookManager = new BookManager();
        $actualDatas = $bookManager->getBookById($_GET['id']);
        $newTitle = $_POST['title'];
        $newDescription = $_POST['description'];
        $newAuthor = $_POST['author'];
        $newAvailability = intval($_POST['availability'], 10);

        if (
            Utils::checkValidityForm([['value' => $newTitle, 'type' => "text"], ['value' => $newDescription, 'type' => 'text'], ['value' => $newAuthor, 'type' => 'text']])
            || $newAvailability === null
        ) {
            /* No detail about form mistakes, it will be improve in a next version.*/
            throw new Exception("Le formulaire n'est pas valide.");
        }
        /* We check if datas are the same, or if we need to update database. */
        if ($newTitle !== $actualDatas->getTitle() || $newDescription !== $actualDatas->getDescription() || $newAuthor !== $actualDatas->getAuthor() || $newAvailability !== $actualDatas->getAvailability()) {
            $filename = $actualDatas->getFilename();
            if (!empty($_FILES['file']['name'])) {
                Utils::deleteFile($filename);
                $filename = Utils::uploadFile($_FILES);
            }
            $book = new Book($newTitle, $newDescription, $newAuthor, $newAvailability, $filename, $_SESSION['user']->getId(), $_GET['id']);
            $bookManager->updateBook($book);
        }
        Utils::redirect("myProfile");
    }

    public function createBook(): void
    {
        $filename = null;
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $author = $_POST['author'] ?? null;
        $availability = intval($_POST['availability'], 10) ?? null;
        if (
            Utils::checkValidityForm([['value' => $title, 'type' => "text"], ['value' => $description, 'type' => 'text'], ['value' => $author, 'type' => 'text']])
            || $availability === null
        ) {
            /* No detail about form mistakes, it will be improve in a next version.*/
            throw new Exception("Le formulaire n'est pas valide.");
        }
        if ($_FILES) {
            $filename = Utils::uploadFile($_FILES);
        }
        $book = new Book($title, $description, $author, $availability, $filename, $_SESSION['user']->getId());
        $bookManager = new BookManager();

        $bookManager->addBook($book, $_SESSION['user']);

        Utils::redirect("myProfile");
    }
    public function deleteBook(): void
    {
        $bookManager = new BookManager();
        $bookManager->deleteBookById($_GET['id'], $_SESSION['user']->getId());
        Utils::redirect('myProfile');

    }




}