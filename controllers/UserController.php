<?php
declare(strict_types=1);

class UserController
{
    /* Displays methods below retrieve the data, perform basic checks, secure the display of data against XSS vulnerabilities, and call the relevant view.*/
    public function inscription(): void
    {
        $view = new View("Inscription");
        $view->render("logForm");
    }

    public function connexion(): void
    {
        $view = new View("Connexion");
        $view->render("logForm");
    }

    public function userProfile(): void
    {
        $bookManager = new BookManager();
        $library = $bookManager->getBooksByUser($_SESSION['user']->getId());
        $library = array_map(function ($book) {
            $book->secureForDisplay();
            return $book;
        }, $library);
        $user = $_SESSION['user'];
        $user->secureForDisplay();
        $view = new View("Modification de votre profil");
        $view->render("userProfile", ['user' => $user, 'library' => $library]);
    }

    public function showPublicProfile(): void
    {
        if (!isset($_GET['id'])) {
            throw new Exception("Vous devez spécifier un utilisateur");
        }
        $userManager = new UserManager();
        $user = $userManager->getUserById($_GET['id']);
        if ($user === -1) {
            throw new Exception("Cet utilisateur n'existe pas");
        }
        $bookManager = new BookManager();
        $library = $bookManager->getBooksByUser($user->getId());
        $user->secureForDisplay();
        $library = array_map(function ($library) {
            $library->secureForDisplay();
            return $library;
        }, $library);
        $view = new View("Profil public de " . $user->getUsername());
        $view->render("userProfile", ['user' => $user, 'library' => $library]);
    }

    /* form processing methods each methods perform basic checks before modify database. */
    public function createUser(): void
    {
        if (
            !Utils::checkValidityForm([
                ['value' => $_POST['username'], 'type' => "text"],
                ['value' => $_POST['email'], 'type' => 'text'],
                ['value' => $_POST['password'], 'type' => 'text']
            ])
        )
            throw new Exception("Tous les champs ne sont pas remplis comme il faut.");

        $userManager = new UserManager();
        $_SESSION['user'] = $userManager->createUser($_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
        Utils::redirect("home");
    }

    public function updateUser(): void
    {
        $userManager = new UserManager();
        $user = $_SESSION['user'];
        $newUsername = $_POST['username'] ?? null;
        $newEmail = $_POST['email'] ?? null;
        $newPassword = $_POST['password'] ?? null;

        $haveNewData = false;
        if (Utils::checkInput(['value' => $newUsername, 'type' => 'username']) && $newUsername !== $user->getUsername()) {
            $haveNewData = true;
            $user->setUsername($_POST['username']);
        }
        if (Utils::checkInput(['value' => $newEmail, 'type' => 'email']) && $newEmail !== $user->getEmail()) {
            $haveNewData = true;
            $user->setEmail($_POST['email']);
        }
        if ($newPassword && Utils::checkInput(['value' => $newPassword, 'type' => 'password'])) {
            $haveNewData = true;
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
        }
        if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
            Utils::deleteFile($user->getAvatar(), true);
            $filename = Utils::uploadFile($_FILES, true);
        }
        if ($filename) {
            $user->setAvatar($filename);
            $haveNewData = true;
        }

        if ($haveNewData) {
            $userManager->updateUser($user);
        }
        Utils::redirect("myProfile");
    }

    public function connectUser(): void
    {
        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($_POST['email']);
        if ($user !== null && password_verify($_POST['password'], $user->getPassword())) {
            $_SESSION['user'] = $user;
            Utils::redirect("home");
        } else {
            throw new Exception("Mauvais identifiants");
        }
    }
    
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        Utils::redirect("home");
    }
}