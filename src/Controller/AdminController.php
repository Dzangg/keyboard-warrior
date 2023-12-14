<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Admin;
use App\Model\Lesson;
use App\Service\Router;
use App\Service\Templating;

class AdminController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $isLogged = $this->isUserLoggedIn();

        if ($isLogged) {
            // Przekieruj na stronę admina lub wygeneruj odpowiednią treść
            $lessons = Lesson::findAll();
            $html = $templating->render('lesson/index.html.php', [
                'lessons' => $lessons,
                'router' => $router,
            ]);
            return $html;
        } else {
            $html = $templating->render('admin/login.html.php', [
                'router' => $router
            ]);
            return $html;
        }
    }


    public function validateAction(Templating $templating, Router $router): ?string
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->authenticate($username, $password)) {
            // Jeśli uwierzytelnienie powiodło się, ustaw flagę zalogowanego użytkownika
//            $_SESSION['is_logged'] = true;
            $expiration = time() + (86400 * 30); // Przykładowe ustawienie ważności ciasteczka (tutaj 30 dni)
            setcookie('is_logged', 'true', $expiration, '/', '', false, true); // Ustawienie ciasteczka

            // Przekieruj na stronę admina lub wygeneruj odpowiednią treść
            $path = $router->generatePath('lesson-index');
            $router->redirect($path);
            return null;
        } else {
            // Jeśli uwierzytelnienie nie powiodło się, wyświetl formularz z informacją o błędzie
            $error = 'Invalid username or password.';
            $html = $templating->render('admin/login.html.php', [
                'router' => $router,
                'error' => $error,
            ]);
            return $html;
        }

    }

    private function isUserLoggedIn(): bool
    {
        return isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === 'true';
    }

    private function authenticate(string $username, string $password): bool
    {
        var_dump($username, $password);
        // Tutaj dodaj logikę uwierzytelniania, np. porównanie z danymi z bazy danych
        // Zwróć true, jeśli uwierzytelnienie powiedzie się, a false w przeciwnym razie
        return true; // Na potrzeby przykładu zawsze zwracamy true
    }
}
