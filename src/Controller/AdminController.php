<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Admin;
use App\Model\Lesson;
use App\Service\Router;
use App\Service\Templating;

class AdminController
{
    public function loginAction(Templating $templating, Router $router): ?string
    {
        $isLogged = $this->isUserLoggedIn();

        if ($isLogged) {
            // Przekieruj na stronę admina lub wygeneruj odpowiednią treść
            $lessons = Lesson::findAll();
            $html = $templating->render('admin/index.html.php', [
                'lessons' => $lessons,
                'router' => $router,
            ]);
            return $html;
        } else {
            $error = '';
            $html = $templating->render('admin/login.html.php', [
                'router' => $router,
                'error' => $error,
            ]);
            return $html;
        }
    }

    public function logoutAction(Templating $templating, Router $router): void
    {
        // admin logout, delete cookie
        $expiration = time() - 3600;
        setcookie('is_logged', '', $expiration, '/');
        $path = $router->generatePath('admin-login');
        $router->redirect($path);
    }


    public function validateAction(Templating $templating, Router $router): ?string
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->authenticate($username, $password)) {
            // Jeśli uwierzytelnienie powiodło się, ustaw flagę zalogowanego użytkownika
            $expiration = time() + (86400 * 30); // Przykładowe ustawienie ważności ciasteczka (tutaj 30 dni)
            setcookie('is_logged', 'true', $expiration, '/', '', false, true); // Ustawienie ciasteczka

            // Przekieruj na stronę admina lub wygeneruj odpowiednią treść
            $path = $router->generatePath('admin-panel');
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


    public function panelAction(Templating $templating, Router $router): ?string
    {
        $isLogged = $this->isUserLoggedIn();
        if ($isLogged) {
            $lessons = Lesson::findAll();
            $html = $templating->render('admin/index.html.php', [
                'router' => $router,
                'lessons' => $lessons,
            ]);
            return $html;
        } else {
            $path = $router->generatePath('admin-login');
            $router->redirect($path);
            return null;
        }
    }

    private function isUserLoggedIn(): bool
    {
        return isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === 'true';
    }

    private function authenticate(string $username, string $password): bool
    {
        // Tutaj dodaj logikę uwierzytelniania, np. porównanie z danymi z bazy danych
        // Zwróć true, jeśli uwierzytelnienie powiedzie się, a false w przeciwnym razie
        return Admin::validateAdmin($username, $password);
    }
}
