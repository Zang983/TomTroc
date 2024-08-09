<?php

class ConversationController
{

    private function getAllUserConversations(): array
    {
        $conversationManager = new ConversationManager();
        $conversationsList = $conversationManager->getAllConversations($_SESSION['user']);
        $conversationsList = array_map(function ($conversation) {
            $conversation['conversation']->secureForDisplay();
            return $conversation;
        }, $conversationsList);
        return $conversationsList;
    }
    private function getConversationById(int $id): ?Conversation
    {
        $conversationManager = new ConversationManager();
        $conversation = $conversationManager->getConversationById($id, $_SESSION['user']);
        if (!$conversation)
            throw new Exception("La conversation n'existe pas.");
        return $conversationManager->getConversationById($id, $_SESSION['user']);
    }
    private function getMessagesByConversation(Conversation $conversation): array
    {
        if ($conversation->getId() === -1)
            return [];
        $messageManager = new MessageManager();
        return $messageManager->getMessagesByConversationId($conversation);

    }
    private function getConversationByReceiver(int $idReceiver)
    {
        $conversationManager = new ConversationManager();
        return $conversationManager->getConversationByUsers($_SESSION['user'], $idReceiver);
    }
    private function createTempConversation($idUser1, $idUser2)
    {
        return new Conversation($idUser1, $idUser2, '', date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), -1);
    }
    private function saveConversation(Conversation $conversation)
    {
        $conversationManager = new ConversationManager();
        $conversationManager->updateConversation($conversation);
    }
    private function changeLastOpeningUser(Conversation $conversation)
    {
        if ($conversation->getIdUser1() === $_SESSION['user']->getId())
            $conversation->setLastOpeningUser1(date('Y-m-d H:i:s'));
        else
            $conversation->setLastOpeningUser2(date('Y-m-d H:i:s'));
    }
    private function createNewConversation($idReceiver, $contentMessage): Conversation
    {
        $conversationManager = new ConversationManager();
        $conversation = new Conversation(
            $_SESSION['user']->getId(),
            $idReceiver,
            $contentMessage,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
        );
        return $conversationManager->createConversation($conversation);
    }
    private function createNewMessage($conversation, $contentMessage): Message
    {
        $idUser = $_SESSION['user']->getId();
        return new Message($contentMessage, date('Y-m-d H:i:s'), $idUser, $conversation->getId());
    }
    private function checkReceiverExistence($idReceiver): void
    {
        $userManager = new UserManager();
        $result = $userManager->getUserById($idReceiver);
        if (!$result)
            Utils::redirect('mailbox');
    }
    public function showMailBox()
    {
        $userId = $_SESSION['user']->getId();
        $conversationList = $this->getAllUserConversations();
        $userManager = new UserManager();
        $messages = [];
        $conversation = null;
        $messageReceiver = null;
        if (isset($_GET['conversationId'])) {
            $conversationId = intval($_GET['conversationId'], 10);
            $conversation = $this->getConversationById($conversationId);
            $messageReceiver = $conversation->getIdUser1() === $userId ? $messageReceiver = $userManager->getUserById($conversation->getIdUser2()) : $messageReceiver = $userManager->getUserById($conversation->getIdUser1());
        }
        if (isset($_GET['idReceiver'])) {
            $idReceiver = intval($_GET['idReceiver'], 10);
            $conversation = $this->getConversationByReceiver($idReceiver);
            $messageReceiver = $userManager->getUserById($idReceiver);
            //S'il n'y a pas de conversation existante, on crée une conversation vide qu'on push dans conversationsList.
            if (!$conversation) {
                $conversationList[] = ["conversation" => $this->createTempConversation($userId, $idReceiver), "receiver" => $userManager->getUserById($idReceiver)];
            }
        }
        if ($conversation) {
            $this->changeLastOpeningUser($conversation);
            $this->saveConversation($conversation);
            $messages = $this->getMessagesByConversation($conversation);
        }
        $view = new View('Votre messagerie');
        $view->render('mailBox', ['conversationsList' => $conversationList, 'messages' => $messages, 'messageReceiver' => $messageReceiver]);
    }
    public function sendMessage()
    {
        /* 
        On vérifie si le message est vide ou non.
        On récupère l'id du receveur et on récupère la conversation.
        Si la conversation n'existe pas on la crée.
        */
        $messageContent = isset($_POST['message']) ? trim($_POST['message']) : null;
        $idReceiver = isset($_GET['idReceiver']) ? intval($_GET['idReceiver'], 10) : null;
        $this->checkReceiverExistence($idReceiver);

        if (!$idReceiver || !$messageContent || empty($messageContent))
            Utils::redirect('mailbox&conversationId=' . $_GET['conversationId']);

        $conversation = $this->getConversationByReceiver($idReceiver);
        if (!$conversation) {
            $conversation = $this->createNewConversation($idReceiver, $messageContent);
        }
        $conversation->setContentLastMessage($messageContent);
        $conversation->setTimestampLastMessage(date('Y-m-d H:i:s'));
        $this->changeLastOpeningUser($conversation);
        $this->saveConversation($conversation);

        $messageManager = new MessageManager();
        $message = $this->createNewMessage($conversation, $messageContent);
        $messageManager->addMessage($message);
        if (isset($_GET['ajax']))
            echo 'success';
        else
            Utils::redirect('mailbox&conversationId=' . $conversation->getId());
    }
    public function countUnreadMessage()
    {
        $conversationManager = new ConversationManager();
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            return $conversationManager->countUnreadMessage($user);
        }
    }

}
