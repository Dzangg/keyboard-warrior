<?php

/** @var \App\Model\Lesson $lesson */
/** @var \App\Service\Router $router */

$title = "{$lesson->getTitle()} ({$lesson->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= $lesson->getTitle() ?></h1>
    <article>
        <h3>Id: <?= $lesson->getId() ?></h3>
        <h3>Title: <?= $lesson->getTitle() ?></h3>
        <h3>Difficulty: <?= $lesson->getDifficulty() ?></h3>
        <h3>Letters: <?= $lesson->getLetters() ?></h3>
        <h3>Content: <?= $lesson->getContent(); ?> </h3>
    </article>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('lesson-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('lesson-edit', ['id'=> $lesson->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
