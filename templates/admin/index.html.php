<?php

/** @var \App\Model\Lesson[] $lessons */
/** @var \App\Service\Router $router */

$title = 'Admin lesson panel';
$bodyClass = 'index';

ob_start(); ?>
<?php
function getDifficultyString($difficulty) {
    switch ($difficulty) {
        case 1:
            return 'Easy';
        case 2:
            return 'Medium';
        case 3:
            return 'Hard';
        default:
            return 'Unknown';
    }
}
?>
    <h1>Admin lesson panel</h1>

    <a href="<?= $router->generatePath('lesson-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($lessons as $lesson): ?>
            <li>
                <h3>Title: <?= $lesson->getTitle() ?></h3>
                <p>Difficulty: <?= $lesson->getDifficultyString() ?></p>

                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('lesson-show', ['id' => $lesson->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('lesson-edit', ['id' => $lesson->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'admin.html.php';
