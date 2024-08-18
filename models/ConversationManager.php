<?php



class ConversationManager
{

    private $db;

    function __construct()
    {
        $this->db = Database::getDB();
    }

    public function getAllConversations(User $user): array
    {
        $conversations = [];
        $rawDatas = $this->db->executeRequest(
            'SELECT c.*, u.* FROM conversations c JOIN users u ON (c.idUser_1 = u.idUser OR c.idUser_2 = u.idUser) WHERE (c.idUser_1 = ? OR c.idUser_2 = ?) AND u.idUser != ?',
            [$user->getId(), $user->getId(), $user->getId()]
        );
        foreach ($rawDatas as $rawData) {
            $conversation = new Conversation(
                $rawData["idUser_1"],
                $rawData["idUser_2"],
                $rawData["contentLastMessage"],
                $rawData["timestampLastMessage"],
                $rawData["lastOpeningUser1"],
                $rawData["lastOpeningUser2"],
                $rawData["idConversation"],
            );
            $receiver = new User(
                $rawData["username"],
                $rawData["email"],
                '',
                $rawData["avatarFilename"],
                $rawData["createdAt"],
                $rawData["idUser"],

            );
            $conversations[] = ['conversation' => $conversation, 'receiver' => $receiver];
        }
        return $conversations;
    }

    public function getConversationByUsers(User $sessionUser, int $userId): Conversation|null
    {
        $rawDatas = $this->db->executeRequest(
            'SELECT * FROM conversations WHERE (idUser_1 = ? AND idUser_2 = ?) OR (idUser_1 = ? AND idUser_2 = ?)',
            [$sessionUser->getId(), $userId, $userId, $sessionUser->getId()]
        );
        if ($rawDatas) {
            return new Conversation(
                $rawDatas[0]["idUser_1"],
                $rawDatas[0]["idUser_2"],
                $rawDatas[0]["contentLastMessage"],
                $rawDatas[0]["timestampLastMessage"],
                $rawDatas[0]["lastOpeningUser1"],
                $rawDatas[0]["lastOpeningUser2"],
                $rawDatas[0]["idConversation"],
            );
        }
        return null;
    }

    public function createConversation(Conversation $conversation): Conversation
    {
        $this->db->executeRequest(
            'INSERT INTO conversations (idUser_1, idUser_2,contentLastMessage,timestampLastMessage) VALUES (?, ?,?,?)',
            [
                $conversation->getIdUser1(),
                $conversation->getIdUser2(),
                $conversation->getContentLastMessage(),
                $conversation->getTimestampLastMessage()
            ]
        );
        $conversation->setId($this->db->lastId());
        return $conversation;
    }

    public function updateConversation(Conversation $conversation)
    {
        $this->db->executeRequest(
            'UPDATE conversations SET contentLastMessage = ?, timestampLastMessage = ?, lastOpeningUser1 = ?, lastOpeningUser2 = ? WHERE idConversation = ?',
            [
                $conversation->getContentLastMessage(),
                $conversation->getTimestampLastMessage(),
                $conversation->getLastOpeningUser1(),
                $conversation->getLastOpeningUser2(),
                $conversation->getId()
            ]
        );
    }

    public function countUnreadMessage(User $user)
    {
        $result = $this->db->executeRequest(
            'SELECT COUNT(*) AS UnreadMessage FROM messages m JOIN conversations c ON m.conversationId = c.idConversation WHERE ((c.idUser_1 = ? AND (m.createdAt > c.lastOpeningUser1 OR c.lastOpeningUser1 IS NULL)) OR (c.idUser_2 = ? AND (m.createdAt > c.lastOpeningUser2 OR c.lastOpeningUser2 IS NULL))) AND m.authorId != ?',
            [$user->getId(), $user->getId(), $user->getId()]
        );
        if ($row = $result[0]) {
            return $row['UnreadMessage'];
        }
    }

    public function getConversationById(int $id, User $user): ?Conversation
    {
        $idUser = $user->getId();
        $rawDatas = $this->db->executeRequest(
            'SELECT * FROM conversations WHERE idConversation = ? AND (idUser_1 = ? OR idUser_2 = ?)',
            [$id, $idUser, $idUser]
        );
        if (isset($rawDatas[0])) {
            return new Conversation(
                $rawDatas[0]["idUser_1"],
                $rawDatas[0]["idUser_2"],
                $rawDatas[0]["contentLastMessage"],
                $rawDatas[0]["timestampLastMessage"],
                $rawDatas[0]["lastOpeningUser1"],
                $rawDatas[0]["lastOpeningUser2"],
                $rawDatas[0]["idConversation"]
            );
        }
        return null;
    }
}