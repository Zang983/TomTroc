<?php

class BookController
{

    public function showHome(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLastBooks();
        $view = new View("Accueil");
        $view->render("home", ["books" => $books]);
    }
    public function editBook(): void
    {
        $bookManager = new BookManager();
        // $book = new Book();
        // if(isset($_GET['id'])){
        //     $book = $bookManager->getBookById($_GET['id']);
        // }
        $book = null;
        $view = new View("Editer un livre");
        $view->render("editBook", ["book" => $book]);
    }

    public function createBook(): void
    {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $url = $_POST['url'] ?? '';

        if (empty($title) || empty($description) || empty($url)) {
            throw new Exception("Tous les champs ne sont pas remplis");
        }
        $book = new Book($title, $description, $url);
        $bookManager = new BookManager();
        $bookManager->addBook($book);

        $view = new View("Editer un livre");
        $view->render("home", ["book" => $book]);

    }
}