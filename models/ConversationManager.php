<?php

class ConversationManager
{

    private $db;
    function __construct()
    {
        $this->db = Database::getDB();
    }

    public function getAllConversation()
    {
        return $this->db->executeRequest('SELECT * FROM conversations INNER JOIN users ON conversations.idUser1 = users.id or conversations.idUser2 = users.id');
    }
}