<?php

class UserManager
{
    private $db;
    function __construct()
    {
        $this->db = Database::getDB();
    }

    public function createUser(string $username, string $email, string $password): User
    {
        $this->db->executeRequest("INSERT INTO users (username,password,email) VALUES (?, ?, ?)", [
            $username,
            $email,
            $password,
        ]);
        $idUser = $this->db->lastId();
        return $this->getUserById($idUser);
    }
    public function getUserByEmail(string $email): ?User
    {
        $user = $this->db->executeRequest("SELECT * FROM users WHERE email = ?", [$email])[0] ?? null;
        return new User($user['username'], $user['email'], $user['password'], $user['avatarFilename'], $user['createdAt'], $user['idUser']);
    }
    public function getUserById(int $id): User
    {
        $user = $this->db->executeRequest("SELECT * FROM users WHERE idUser = ?", [$id])[0];
        return new User($user['username'], $user['email'], $user['password'], $user['avatarFilename'], $user['createdAt'], $user['idUser']);
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

}