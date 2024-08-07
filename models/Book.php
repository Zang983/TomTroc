<?php


class Book
{
    public function __construct(private string $title, private string $description, private string $author, private int $availability = 1, private string|null $filename, private int $ownerId = -1, private int $id = -1)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function getAvailability(): bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): void
    {
        $this->availability = $availability;
    }

    public function setOwnerName(string $name): void
    {
        $this->ownerUsername = $name;
    }
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): void
    {
        $this->ownerId = $ownerId;
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
        $this->filename = htmlspecialchars($this->filename, ENT_QUOTES,"UTF-8");
        $this->title = htmlspecialchars($this->title, ENT_QUOTES,"UTF-8");
        $this->description = htmlspecialchars($this->description, ENT_QUOTES,"UTF-8");
        $this->author = htmlspecialchars($this->author, ENT_QUOTES,"UTF-8");
    }

}