<?php



/*
Simple creation of the database connection; studying the singleton pattern is relevant.
*/

class Database
{
    private static Database|null $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        } catch (PDOException $error) {
            throw new Exception('Error : ' . $error->getMessage());
        }
    }

    public static function getDB(): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /*
    Execute the provided query and return the result if there is one.
    */
    public function executeRequest(string $request, array $params = null): array
    {
        if ($params == null) {
            $state = $this->pdo->query($request);
        } else {
            $state = $this->pdo->prepare($request);
            $state->execute($params);
        }
        return $state->fetchAll();
    }

    public function lastId(): string
    {
        return $this->pdo->lastInsertId();
    }

    public function showError(): array
    {
        return $this->pdo->errorInfo();
    }
}