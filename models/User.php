<?php

class User {

    function __construct(private string $username, private string $email, private string $password,private string|null $avatar = null,private string $createdAt, private int $id = -1)
    {
        if($avatar === null){
            $this->avatar = "no-image.svg";
        }
    }
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getAvatar():string|null{
        return $this->avatar;
    }
    public function setAvatar(string $filename):void{
        $this->avatar = $filename;
    }
    public function getCreatedAt():string{
        return $this->createdAt;
    }

}