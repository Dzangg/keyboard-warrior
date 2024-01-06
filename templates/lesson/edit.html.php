<?php

/** @var \App\Model\Lesson $lesson */
/** @var \App\Service\Router $router */

$title = "Edit Lesson {$lesson->getTitle()} ({$lesson->getId()})";
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('lesson-edit', ['id' => $lesson->getId()]) ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="lesson-edit">
        <input type="hidden" name="id" value="<?= $lesson->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('admin-panel') ?>">Back to list</a>
        </li>
        <li>
            <form action="<?= $router->generatePath('lesson-delete', ['id' => $lesson->getId()]) ?>" method="post">
                <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                <input type="hidden" name="action" value="lesson-delete">
                <input type="hidden" name="id" value="<?= $lesson->getId() ?>">
            </form>
        </li>
    </ul>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
