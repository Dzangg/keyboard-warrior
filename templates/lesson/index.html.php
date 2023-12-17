<?php

/** @var \App\Model\Lesson[] $lessons */
/** @var \App\Service\Router $router */

$title = 'Lesson List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Lessons List</h1>

    <ul class="index-list">
        <?php foreach ($lessons as $lesson): ?>
            <li>
                <h3 id="lesson<?= $lesson->getId() ?>">Title: <?= $lesson->getTitle() ?></h3>
                <p>Difficulty: <?= $lesson->getDifficulty() ?></p>
            </li>
        <?php endforeach; ?>
    </ul>


<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
