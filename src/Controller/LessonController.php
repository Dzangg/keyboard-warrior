<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Lesson;
use App\Service\Router;
use App\Service\Templating;

class LessonController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $lessons = Lesson::findAllSortedByDifficulty();
        $html = $templating->render('lesson/index.html.php', [
            'lessons' => $lessons,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if (!$this->isUserLoggedIn()) {
            $path = $router->generatePath('admin-login');
            $router->redirect($path);
            return null;
        }
        if ($requestPost) {
            $lesson = Lesson::fromArray($requestPost);
            // @todo missing validation
            $lesson->save();

            $path = $router->generatePath('admin-panel');
            $router->redirect($path);
            return null;
        } else {
            $lesson = new Lesson();
        }

        $html = $templating->render('lesson/create.html.php', [
            'lesson' => $lesson,
            'router' => $router,
        ]);
        return $html;
    }
    public function customAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        $html = $templating->render('lesson/createcustom.html.php', [
            'router' => $router,
        ]);
        return $html;
    }

    public function customPlayAction(string $lessonId, string $lessonTitle, string $lessonLetters, string $lessonContent, string $lessonDifficulty, Templating $templating, Router $router): ?string
    {
        $html = $templating->render('lesson/playcustom.html.php', [
            'router' => $router,
            'lessonId' => $lessonId,
            'lessonTitle' => $lessonTitle,
            'lessonLetters' => $lessonLetters,
            'lessonContent' => $lessonContent,
            'lessonDifficulty' => $lessonDifficulty,

        ]);
        return $html;
    }

    public function editAction(int $lessonId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        if (!$this->isUserLoggedIn()) {
            $path = $router->generatePath('admin-login');
            $router->redirect($path);
            return null;
        }
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            throw new NotFoundException("Missing lesson with id $lessonId");
        }

        if ($requestPost) {
            $lesson->fill($requestPost);
            // @todo missing validation
            $lesson->save();

            $path = $router->generatePath('admin-panel');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('lesson/edit.html.php', [
            'lesson' => $lesson,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $lessonId, Templating $templating, Router $router): ?string
    {
        if (!$this->isUserLoggedIn()) {
            $path = $router->generatePath('admin-login');
            $router->redirect($path);
            return null;
        }
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            throw new NotFoundException("Missing lesson with id $lessonId");
        }

        $html = $templating->render('lesson/show.html.php', [
            'lesson' => $lesson,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $lessonId, Router $router): ?string
    {
        if (!$this->isUserLoggedIn()) {
            $path = $router->generatePath('admin-login');
            $router->redirect($path);
            return null;
        }
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            throw new NotFoundException("Missing lesson with id $lessonId");
        }

        $lesson->delete();
        $path = $router->generatePath('admin-panel');
        $router->redirect($path);
        return null;
    }

    public function playAction(int $lessonId, Templating $templating, Router $router): ?string
    {
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            throw new NotFoundException("Missing lesson with id $lessonId");
        }

        $html = $templating->render('lesson/play.html.php', [
            'lesson' => $lesson,
            'router' => $router,
        ]);
        return $html;
    }

    public function isUserLoggedIn(): bool
    {
        return isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === 'true';
    }
}
