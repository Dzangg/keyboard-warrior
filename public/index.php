<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();

$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
switch ($action) {
    case 'lesson-index':
    case null:
        $controller = new \App\Controller\LessonController();
        $view = $controller->indexAction($templating, $router);
        break;
    case 'lesson-create':
        $controller = new \App\Controller\LessonController();
        $view = $controller->createAction($_REQUEST['lesson'] ?? null, $templating, $router);
        break;
    case 'lesson-custom-create':
        $controller = new \App\Controller\LessonController();
        $view = $controller->customAction($_REQUEST['lesson'] ?? null, $templating, $router);
        break;
    case 'lesson-custom-play':
        $lessonId = $_REQUEST['lessonId'] ?? null;
        $lessonTitle = $_REQUEST['lessonTitle'] ?? null;
        $lessonLetters = $_REQUEST['lessonLetters'] ?? null;
        $lessonContent = $_REQUEST['lessonContent'] ?? null;
        $lessonDifficulty = $_REQUEST['lessonDifficulty'] ?? null;

        $controller = new \App\Controller\LessonController();
        $view = $controller->customPlayAction($lessonId, $lessonTitle, $lessonLetters, $lessonContent, $lessonDifficulty, $templating, $router);
        break;
    case 'lesson-edit':
        $lessonId = $_REQUEST['id'] ?? null;
        if (! $lessonId) {
            break;
        }
        $controller = new \App\Controller\LessonController();
        $view = $controller->editAction($lessonId, $_REQUEST['lesson'] ?? null, $templating, $router);
        break;
    case 'lesson-show':
        $lessonId = $_REQUEST['id'] ?? null;
        if (! $lessonId) {
            break;
        }
        $controller = new \App\Controller\LessonController();
        $view = $controller->showAction($lessonId, $templating, $router);
        break;
    case 'lesson-delete':
        $lessonId = $_REQUEST['id'] ?? null;
        if (! $lessonId) {
            break;
        }
        $controller = new \App\Controller\LessonController();
        $view = $controller->deleteAction($lessonId, $router);
        break;
    case 'lesson-play':
        $lessonId = $_REQUEST['id'] ?? null;
        if (! $lessonId) {
            break;
        }
        $controller = new \App\Controller\LessonController();
        $view = $controller->playAction($lessonId, $templating, $router);
        break;

    case 'admin-login':
        $controller = new \App\Controller\AdminController();
        $view = $controller->loginAction($templating, $router);
        break;

    case 'admin-logout':
        $controller = new \App\Controller\AdminController();
        $controller->logoutAction($templating, $router);
        break;

    case 'admin-validate':
        $controller = new \App\Controller\AdminController();
        $view = $controller->validateAction($templating, $router);
        break;

    case 'admin-panel':
        $controller = new \App\Controller\AdminController();
        $view = $controller->panelAction($templating, $router);
        break;

    default:
        $view = 'Not found';
        break;
}
if ($view) {
    echo $view;
}



