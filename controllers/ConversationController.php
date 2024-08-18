<?php
declare(strict_types=1);


class ConversationController
{
    /*
    Private methods are used to retrieve data from the database, create new objects, and update the database to simplify the code and make it more readable.
    */

    private function getAllUserConversations(): array
    {
        $conversationManager = new ConversationManager();
        $conversationsList = $conversationManager->getAllConversations($_SESSION['user']);
        return $conversationsList;
    }

    private function getConversationById(int $id): ?Conversation
    {
        $conversationManager = new ConversationManager();
        $conversation = $conversationManager->getConversationById($id, $_SESSION['user']);
        if (!$conversation) {
            throw new Exception("La conversation n'existe pas.");
        }
        return $conversationManager->getConversationById($id, $_SESSION['user']);
    }

    private function getMessagesByConversation(Conversation $conversation): array
    {
        if ($conversation->getId() === -1) {
            return [];
        }
        $messageManager = new MessageManager();
        return $messageManager->getMessagesByConversationId($conversation);
    }

    private function getConversationByReceiver(int $idReceiver)
    {
        $conversationManager = new ConversationManager();
        return $conversationManager->getConversationByUsers($_SESSION['user'], $idReceiver);
    }

    private function createTempConversation($idUser1, $idUser2): Conversation
    {
        return new Conversation(
            $idUser1,
            $idUser2,
            '',
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            -1
        );
    }

    private function saveConversation(Conversation $conversation): void
    {
        $conversationManager = new ConversationManager();
        $conversationManager->updateConversation($conversation);
    }

    private function changeLastOpeningUser(Conversation $conversation): void
    {
        if ($conversation->getIdUser1() === $_SESSION['user']->getId()) {
            $conversation->setLastOpeningUser1(date('Y-m-d H:i:s'));
        } else {
            $conversation->setLastOpeningUser2(date('Y-m-d H:i:s'));
        }
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
        if (!$result) {
            Utils::redirect('mailbox');
        }
    }

    /**
     * This method is used to display the mailbox page.
     * It retrieves all the conversations of the user, the messages of the selected conversation, and the user with
     * whom the user is talking. And if conversation doesn't exist, it creates a new temporary one.
     * @return void
     */
    public function showMailBox(): void
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
            $messageReceiver = $conversation->getIdUser1() === $userId ? $messageReceiver = $userManager->getUserById(
                $conversation->getIdUser2()
            ) : $messageReceiver = $userManager->getUserById($conversation->getIdUser1());
        }
        if (isset($_GET['idReceiver'])) {
            $idReceiver = intval($_GET['idReceiver'], 10);
            $conversation = $this->getConversationByReceiver($idReceiver);
            $messageReceiver = $userManager->getUserById($idReceiver);
            if (!$conversation) {
                $conversationList[] = [
                    "conversation" => $this->createTempConversation($userId, $idReceiver),
                    "receiver" => $userManager->getUserById($idReceiver)
                ];
            }
        }
        if ($conversation) {
            $this->changeLastOpeningUser($conversation);
            $this->saveConversation($conversation);
            $messages = $this->getMessagesByConversation($conversation);
        }
        $conversationList = array_map(function ($conversation) {
            $conversation['conversation']->secureForDisplay();
            return $conversation;
        }, $conversationList);
        $messages = array_map(function ($message) {
            $message->secureForDisplay();
            return $message;
        }, $messages);
        $view = new View('Votre messagerie');
        $view->render(
            'mailBox',
            ['conversationsList' => $conversationList, 'messages' => $messages, 'messageReceiver' => $messageReceiver]
        );
    }

    /**
     * This method is used to send a message. We can send a message from different pages, so we need to check if the
     * message is empty, if the receiver exists, if the conversation exists, and if not, we create a new one.
     * @return void
     */
    public function sendMessage(): void
    {
        $messageContent = isset($_POST['message']) ? trim($_POST['message']) : null;
        $idReceiver = isset($_GET['idReceiver']) ? intval($_GET['idReceiver'], 10) : null;
        $this->checkReceiverExistence($idReceiver);

        if (!$idReceiver || !$messageContent || empty($messageContent)) {
            Utils::redirect('mailbox&conversationId=' . $_GET['conversationId']);
        }

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
        if (isset($_GET['ajax'])) {
            echo 'success';
        } else {
            Utils::redirect('mailbox&conversationId=' . $conversation->getId());
        }
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
