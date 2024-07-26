<?php
require_once 'config/autoload.php';
require_once 'config/config.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
// $action = Utils::request('action', 'home');
$action = 'home';
if (isset($_GET['action']))
    $action = $_GET['action'];

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $bookController = new bookController();
            $bookController->showHome();
            break;
        case 'market':
            $bookController = new bookController();
            $bookController->showMarket();
            break;
        case 'detailBook':
            $bookController = new bookController();
            $bookController->detailBook();
            break;

        // Pages gérant l'inscription / connexion.
        case 'connexion':
            $userController = new UserController();
            $userController->connexion();
            break;
        case 'inscription':
            $userController = new UserController();
            $userController->showInscriptionForm();
            break;
        case 'connectUser':
            $userController = new UserController();
            $userController->connectUser();
            break;
        case 'createUser':
            $userController = new UserController();
            $userController->createUser();
            break;
        case 'logout':
            $userController = new UserController();
            $userController->logout();
            break;

        /* Page nécessitant d'être connecté.*/

        case 'myProfile':
            $userController = new UserController();
            $userController->userProfile();
            break;
        case 'newBookForm':
            $bookController = new bookController();
            $bookController->newBookForm();
            break;
        case 'updateUser':
            $userController = new UserController();
            $userController->updateUser();
            break;
        case 'editBookForm':
            $bookController = new bookController();
            $bookController->showEditBookForm();
            break;
        case 'editBook':
            $bookController = new bookController();
            $bookController->updateBook();
            break;
        case 'createBook':
            $bookController = new bookController();
            $bookController->createBook();
            break;
        case 'deleteBook':
            $bookController = new bookController();
            $bookController->deleteBook();
            break;
        case 'profile':
            $userController = new UserController();
            $userController->showPublicProfile();
            break;
        case 'mailbox':
            $messageController = new chatController();
            $messageController->showChatBox();
            break;
        case 'updateBook':
            $bookController = new bookController();
            $bookController->updateBook();
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
