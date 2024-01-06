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
            <a href="<?= $router->generatePath('lesson-play',  ['id' => $lesson->getId()]) ?>">Back to list
                <h3 id="lesson<?= $lesson->getId() ?>">Title: <?= $lesson->getTitle() ?></h3>
                <p>Difficulty: <?= $lesson->getDifficulty() ?></p>
            </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        let doneLessons = JSON.parse(localStorage.getItem('data')) || [];

        function loadLesson() {
            for (let i = 0; i < doneLessons.length; i++) {
                let element = document.getElementById("lesson" + doneLessons[i]);
                element.style.color = 'red';
            }
        }

        function setLesson(id) {
            if (doneLessons.includes(id)) {
                return;
            }
            localStorage.setItem('data', JSON.stringify([...doneLessons, id]));
        }

        setLesson(2);
        loadLesson();
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

