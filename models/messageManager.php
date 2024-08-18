<?php
declare(strict_types=1);


class MessageManager
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getDB();
    }

    public function addMessage(Message $message): void
    {
        $this->db->executeRequest(
            'INSERT INTO messages (content, createdAt, conversationId, authorId) VALUES (?, ?, ?, ?)',
            [$message->getContent(), $message->getCreatedAt(), $message->getIdConversation(), $message->getAuthorId()]
        );
    }

    public function getMessagesByConversationId(Conversation $conversation): array
    {
        $messages = [];
        $rawDatas = $this->db->executeRequest(
            'SELECT * FROM messages WHERE conversationId = ? ORDER BY createdAt',
            [$conversation->getId()]
        );
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