<?php

class BookManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    /* Method which udpdate db*/
    public function addBook(Book $book, User $user): void
    {
        $this->db->executeRequest(
            'INSERT INTO books (title, description, author, imageFilename,availability,OwnerId) VALUES (?,?,?,?,?,?)',
            [
                Utils::secureInput($book->getTitle()),
                Utils::secureInput($book->getDescription()),
                Utils::secureInput($book->getAuthor()),
                $book->getFilename() === 'no-image.svg' ? null : $book->getFilename(),
                intval($book->getAvailability(), 10),
                $book->getOwnerId()
            ]
        );
    }
    public function deleteBookById(int $idBook, int $idUser): array
    {

        return $this->db->executeRequest('DELETE FROM books WHERE idBook = ? AND ownerId = ?', [$idBook, $idUser]);
    }
    public function updateBook(Book $book): void
    {
        var_dump($book);
        $this->db->executeRequest(
            'UPDATE books SET title = ?, description = ?, author = ?, availability = ?, imageFilename = ?, updatedAt = ? WHERE idBook = ?',
            [
                $book->getTitle(),
                $book->getDescription(),
                $book->getAuthor(),
                $book->getAvailability() === null ? null : intval($book->getAvailability(), 10),
                $book->getFilename() === 'no-image.svg' ? null : $book->getFilename(),
                date('Y-m-d H:i:s', time()),
                $book->getId()
            ]
        );

    }


    /* Method which read db*/
    function getLastBooks(int $limit = 4): array
    {
        $rawDatas = $this->db->executeRequest('SELECT * FROM books INNER JOIN users ON  books.OwnerId = users.idUser ORDER BY books.createdAt DESC LIMIT ' . $limit);
        $datas = array_map(function ($datas) {
            return [
                'book' => new Book($datas['title'], $datas['description'], $datas['author'], $datas['availability'], $datas['imageFilename'], $datas['ownerId'], $datas['idBook']),
                'user' => new User($datas['username'], $datas['email'], $datas['password'], $datas['createdAt'], $datas['idUser'])
            ];
        }, $rawDatas);
        return $datas;
    }
    function getAllBooks(): array
    {
        $rawDatas = $this->db->executeRequest('SELECT * FROM books INNER JOIN users ON books.OwnerId = users.idUser');
        $datas = array_map(function ($datas) {
            return [
                'book' => new Book($datas['title'], $datas['description'], $datas['author'], $datas['availability'], $datas['imageFilename'], $datas['ownerId'], $datas['idBook']),
                'user' => new User($datas['username'], $datas['email'], $datas['password'], $datas['createdAt'], $datas['idUser'])
            ];
        }, $rawDatas);
        return $datas;
    }
    function getBookById(int $id, bool $includeOwner = false): array|Book
    {
        if ($includeOwner) {
            $rawDatas = $this->db->executeRequest('SELECT * FROM books INNER JOIN users ON books.OwnerId = users.idUser WHERE idBook = ?', [$id]);
            return [
                'book' => new Book($rawDatas[0]['title'], $rawDatas[0]['description'], $rawDatas[0]['author'], $rawDatas[0]['availability'], $rawDatas[0]['imageFilename'], $rawDatas[0]['ownerId'], $rawDatas[0]['idBook']),
                'user' => new User($rawDatas[0]['username'], $rawDatas[0]['email'], $rawDatas[0]['password'], $rawDatas[0]['avatarFilename'], $rawDatas[0]['createdAt'], $rawDatas[0]['idUser'])
            ];
        }
        $rawDatas = $this->db->executeRequest('SELECT * FROM books WHERE idBook = ?', [$id]);
        return new Book($rawDatas[0]['title'], $rawDatas[0]['description'], $rawDatas[0]['author'], $rawDatas[0]['availability'], $rawDatas[0]['imageFilename'], $rawDatas[0]['ownerId'], $rawDatas[0]['idBook']);
    }
    public function getBooksByUser(int $userId): array
    {
        $rawBooks = $this->db->executeRequest('SELECT * FROM books WHERE OwnerId = ' . $userId);
        $books = array_map(function ($book) {
            return new Book($book['title'], $book['description'], $book['author'], $book['availability'], $book['imageFilename'], $book['ownerId'], $book['idBook']);
        }, $rawBooks);
        return $books;
    }

    /**
     * // This method search books approximately by title or author
     * @param string $search
     * @return array with books datas and their owners datas
     */
    public function searchBooks(string $search): array
    {
        $rawDatas = $this->db->executeRequest('SELECT * FROM books INNER JOIN users WHERE books.ownerId = users.idUser AND( title  LIKE ? OR author LIKE ?)', ['%' . $search . '%','%' . $search . '%']);
        $datas = array_map(function ($datas) {
            return [
                'book' => new Book($datas['title'], $datas['description'], $datas['author'], $datas['availability'], $datas['imageFilename'], $datas['ownerId'], $datas['idBook']),
                'user' => new User($datas['username'], $datas['email'], $datas['password'], $datas['createdAt'], $datas['idUser'])
            ];
        }, $rawDatas);
        return $datas;
    }


}