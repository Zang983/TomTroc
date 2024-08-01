<?php

class ConversationController
{
    public function showMailBox()
    {
        if (isset($_GET['idReceiver'])) {
            $this->getAllMessages();
            return;
        }
        $conversationManager = new ConversationManager();
        $conversationsList = $conversationManager->getAllConversations($_SESSION['user']);
        $view = new View('Votre messagerie');
        $view->render('mailBox', ['conversationsList' => $conversationsList]);
    }
    public function getAllMessages()
    {
        $idReceiver = isset($_GET['idReceiver']) ? intval($_GET['idReceiver'], 10) : -1;
        $conversationManager = new ConversationManager();
        $conversationsList = $conversationManager->getAllConversations($_SESSION['user']);
        $messages = [];

        foreach ($conversationsList as $entry) {
            if ($entry['conversation']->getIdUser2() === $idReceiver || $entry['conversation']->getIdUser1() === $idReceiver) {
                $messageManager = new MessageManager();
                $messages = $messageManager->getAllMessages($entry['conversation']->getId());
                $isUser2 = $entry['conversation']->getIdUser2() === $_SESSION['user']->getId();
                $isUser2 ? $entry['conversation']->setLastOpeningUser2(date('Y-m-d H:i:s')) : $entry['conversation']->setLastOpeningUser1(date('Y-m-d H:i:s'));
                $conversationManager->updateConversation($entry['conversation']);
                break;
            }
        }
        $view = new View('Votre messagerie');
        $view->render('mailBox', ['conversationsList' => $conversationsList, 'messages' => $messages]);
    }

    public function sendMessage()
    {
        /* Pour écrire un message, on vérifie si la conversation entre les deux utilisateur existe, on récupère l'id de l'utilisateur de session, puis celui transmis en paramètre.
        Si la conversation n'existe pas, on la crée.

        On transmet la conversation existante, ou la nouvelle conversation, à la méthode addMessage du MessageManager.
        */

        if (isset($_POST['message']) && isset($_GET['idReceiver'])) {
            $conversationManager = new ConversationManager();
            $userManager = new UserManager();
            $user = $_SESSION['user'];
            $idReceiver = intval($_GET['idReceiver'], 10);
            $userExist = $userManager->getUserById($idReceiver);
            $contentMessage = Utils::secureInput($_POST['message']);
            if (!$userExist) {
                echo 'inexistant';// Si l'utilisateur n'existe pas, on renvoie inexistant.
            }

            $conversation = $conversationManager->getConversationByUsers($user, $idReceiver);

            if ($conversation !== -1) {//Si la conversation existe déjà, on met à jour le dernier message et la date de dernier message.
                $conversation->setContentLastMessage($contentMessage);
                $conversation->setTimestampLastMessage(date('Y-m-d H:i:s'));
            } else {//Si la conversation n'existe pas, on la crée.
                $conversation = new Conversation(
                    $user->getId(),
                    $idReceiver,
                    $_POST['message'],
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s'),
                );

                $conversationManager->createConversation($conversation);
            }
            $messageManager = new MessageManager();
            // On crée le nouveau message et on l'enregistre.
            $message = new Message($contentMessage, date('Y-m-d H:i:s'), $conversation->getId(), $user->getId());
            $messageManager->addMessage($message);
            $conversationManager->updateConversation($conversation);
            echo 'success';
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
