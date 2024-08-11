<?php

class Conversation
{
    private $usernameReceiver;
    private $avatarReceiver;
    function __construct(private int $idUser1, private int $idUser2, private string $contentLastMessage, private string|null $timestampLastMessage, private string|null $lastOpeningUser1, private string|null $lastOpeningUser2, private int $id = -1)
    {
    }
    public function getIdUser1(): int
    {
        return $this->idUser1;
    }

    public function setIdUser1(int $idUser1): void
    {
        $this->idUser1 = $idUser1;
    }

    public function getIdUser2(): int
    {
        return $this->idUser2;
    }

    public function setIdUser2(int $idUser2): void
    {
        $this->idUser2 = $idUser2;
    }

    public function getContentLastMessage(): string
    {
        return $this->contentLastMessage;
    }

    public function setContentLastMessage(string $contentLastMessage): void
    {
        $this->contentLastMessage = $contentLastMessage;
    }

    public function getTimestampLastMessage(): string
    {
        return $this->timestampLastMessage;
    }

    public function setTimestampLastMessage(string $timestampLastMessage): void
    {
        $this->timestampLastMessage = $timestampLastMessage;
    }

    public function getLastOpeningUser1(): string|null
    {
        return $this->lastOpeningUser1;
    }

    public function setLastOpeningUser1(string $lastOpeningUser1): void
    {
        $this->lastOpeningUser1 = $lastOpeningUser1;
    }

    public function getLastOpeningUser2(): string|null
    {
        return $this->lastOpeningUser2;
    }

    public function setLastOpeningUser2(string $lastOpeningUser2): void
    {
        $this->lastOpeningUser2 = $lastOpeningUser2;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    public function secureForDisplay():void{
        $this->contentLastMessage = htmlspecialchars($this->contentLastMessage,ENT_QUOTES,"UTF-8");
    }

}