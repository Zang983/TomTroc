<?php
/*
Simple creation of the database connection; studying the singleton pattern is relevant.
*/

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        } catch (PDOException $error) {
            throw new Exception('Error : ' . $error->getMessage());
        }
    }

    public static function getDB()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    /*
    Execute the provided query and return the result if there is one.
    */
    public function executeRequest(string $request, array $params = null)
    {
        if ($params == null) {
            $state = $this->pdo->query($request);
        } else {
            $state = $this->pdo->prepare($request);
            $state->execute($params);
        }
        return $state->fetchAll();
    }

    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }
    
    public function showError()
    {
        return $this->pdo->errorInfo();
    }
}