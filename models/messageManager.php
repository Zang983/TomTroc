<?php

class MessageManager
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    public function addMessage(Message $message)
    {
        $this->db->executeRequest('INSERT INTO messages (content, createdAt, conversationId, authorId) VALUES (?, ?, ?, ?)', [$message->getContent(), $message->getCreatedAt(), $message->getIdConversation(), $message->getAuthorId()]);
    }

}