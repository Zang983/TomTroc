<?php

class BookManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    function getLastBooks()
    {
        if ($this->db){
            return [
                ['title' => 'Le seigneur des anneaux', 'author' => 'J.R.R. Tolkien'],
                ['title' => 'Harry Potter', 'author' => 'J.K. Rowling'],
                ['title' => 'Le meilleur des mondes', 'author' => 'Aldous Huxley']
            ];
        }

        else{
            return ["error" => "Problème de conexion à la base de données"];

        }
    }

}