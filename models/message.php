<?php
declare(strict_types=1);


class Message
{
    public function __construct(
        public string $content,
        public string $createdAt,
        public int $authorId,
        public int $idConversation = -1,
        public int $idMessage = -1
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getIdConversation(): int
    {
        return $this->idConversation;
    }

    public function setIdConversation(int $idConversation): void
    {
        $this->idConversation = $idConversation;
    }

    public function secureForDisplay(): void
    {
        $this->content !== null ? htmlspecialchars($this->content, ENT_QUOTES, "UTF-8") : null;
    }

}