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
    public function getAllMessages(int $conversationId): array
    {
        $messages = [];
        $rawDatas = $this->db->executeRequest('SELECT * FROM messages WHERE conversationId = ? ORDER BY createdAt', [$conversationId]);
        foreach ($rawDatas as $rawData) {
            $messages[] = new Message(
                $rawData["content"],
                $rawData["createdAt"],
                $rawData["authorId"],
                $rawData["conversationId"],
                $rawData["idMessage"],

            );
        }
        return $messages;
    }
}