<?php
require_once 'config/autoload.php';
require_once 'config/config.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
// $action = Utils::request('action', 'home');
$action = 'home';
if (isset($_GET['action']))
    $action = $_GET['action'];

$actions = [//Liste des actions possibles nécessitant d'être connecté.
    'myProfile',
    'newBookForm',
    'updateUser',
    'editBookForm',
    'editBook',
    'createBook',
    'deleteBook',
    'mailbox',
    'updateBook',
    'sendMessage',
];
// Try catch global pour gérer les erreurs
try {
    if (in_array($action, $actions) && !isset($_SESSION['user'])) {
        throw new Exception("Vous devez être connecté pour accéder à cette page.");
    }
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $bookController = new BookController();
            $bookController->showHome();
            break;
        case 'market':
            $bookController = new BookController();
            $bookController->showMarket();
            break;
        case 'detailBook':
            $bookController = new BookController();
            $bookController->detailBook();
            break;

        // Pages gérant l'inscription / connexion.
        case 'connexion':
            $userController = new UserController();
            $userController->connexion();
            break;
        case 'inscription':
            $userController = new UserController();
            $userController->inscription();
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
            $bookController = new BookController();
            $bookController->newBookForm();
            break;
        case 'updateUser':
            $userController = new UserController();
            $userController->updateUser();
            break;
        case 'editBookForm':
            $bookController = new BookController();
            $bookController->showEditBookForm();
            break;
        case 'editBook':
            $bookController = new BookController();
            $bookController->updateBook();
            break;
        case 'createBook':
            $bookController = new BookController();
            $bookController->createBook();
            break;
        case 'deleteBook':
            $bookController = new BookController();
            $bookController->deleteBook();
            break;
        case 'profile':
            $userController = new UserController();
            $userController->showPublicProfile();
            break;
        case 'mailbox':
            $messageController = new ConversationController();
            $messageController->showMailBox();
            break;
        case 'updateBook':
            $bookController = new BookController();
            $bookController->updateBook();
            break;

        /* Route dynamique (AJAX) */
        case 'sendMessage':
            $messageController = new ConversationController();
            $messageController->sendMessage();
            break;
        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('errorPage', ['errorMessage' => $e->getMessage()]);
}
