<?php

class ChatController
{
    public function showChatBox()
    {
    $view = new View('Votre messagerie');
    $view->render('chatBox');
    }
    public function getAllMessages(){
        $messageManager = new MessageManager();
        $messages = $messageManager->getAllMessages();
        $view = new View('Votre messagerie');
        $view->render('chatBox', ['messages' => $messages]);
    }
}