<?php
declare(strict_types=1);
class UserManager
{
    private $db;
    function __construct()
    {
        $this->db = Database::getDB();
    }

    /* Methods which write datas */
    public function createUser(string $username, string $email, string $password): User
    {
        $this->db->executeRequest("INSERT INTO users (username,password,email) VALUES (?, ?, ?)", [
            $username,
            $password,
            $email,
        ]);
        $idUser = $this->db->lastId();
        return $this->getUserById($idUser);
    }

    public function updateUser(User $user): void
    {
        $this->db->executeRequest("UPDATE users SET username = ?, email = ?, password = ?, avatarFilename = ? WHERE idUser = ?", [
            $user->getUsername(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getAvatar(),
            $user->getId()
        ]);
    }

    public function deleteUser(User $user): void
    {
        $this->db->executeRequest("DELETE FROM users WHERE idUser = ?", [$user->getId()]);
    }

    /* Methods which read datas */
    public function getUserByEmail(string $email): ?User
    {
        $user = $this->db->executeRequest("SELECT * FROM users WHERE email = ?", [$email]);
        if ($user) {
            $user = $user[0];
            return new User($user['username'], $user['email'], $user['password'], $user['avatarFilename'], $user['createdAt'], $user['idUser']);
        }
        return null;
    }
    
    public function getUserById(int $id): User|null
    {
        $user = $this->db->executeRequest("SELECT * FROM users WHERE idUser = ?", [$id])[0] ?? null;
        if ($user)
            return new User($user['username'], $user['email'], $user['password'], $user['avatarFilename'], $user['createdAt'], $user['idUser']);
        return null;
    }
}