<?php

class BookController{
    
    public function showHome(): void{
        $bookManager = new BookManager();
        $books = $bookManager->getLastBooks();
        $view = new View("Accueil");
        $view->render("home",["books"=>$books]);
    }
}