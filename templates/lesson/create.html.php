<?php

/** @var \App\Model\Lesson $lesson */
/** @var \App\Service\Router $router */

$title = 'Create Lesson';
$bodyClass = "edit";

ob_start(); ?>
    <h1>Create Lesson</h1>
    <form action="<?= $router->generatePath('lesson-create') ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="action" value="lesson-create">
    </form>

    <a href="<?= $router->generatePath('lesson-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
