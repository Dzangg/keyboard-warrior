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
        $lessons = Lesson::findAll();
        $html = $templating->render('lesson/index.html.php', [
            'lessons' => $lessons,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $lesson = Lesson::fromArray($requestPost);
            // @todo missing validation
            $lesson->save();

            $path = $router->generatePath('lesson-index');
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

    public function editAction(int $lessonId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            throw new NotFoundException("Missing lesson with id $lessonId");
        }

        if ($requestPost) {
            $lesson->fill($requestPost);
            // @todo missing validation
            $lesson->save();

            $path = $router->generatePath('lesson-index');
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
        $lesson = Lesson::find($lessonId);
        if (! $lesson) {
            throw new NotFoundException("Missing lesson with id $lessonId");
        }

        $lesson->delete();
        $path = $router->generatePath('lesson-index');
        $router->redirect($path);
        return null;
    }
}
