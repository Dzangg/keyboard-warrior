<?php

/** @var \App\Model\Lesson[] $lessons */
/** @var \App\Service\Router $router */

include 'function.php';

$title = 'Lesson List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Lessons List</h1>

    <ul class="index-list">
        <?php foreach ($lessons as $lesson): ?>

        <li>
            <a href="<?= $router->generatePath('lesson-play',  ['id' => $lesson->getId()]) ?>">
                <h3 id="lesson<?= $lesson->getId() ?>">Title: <?= $lesson->getTitle() ?></h3>
                <p>Difficulty: <?= $lesson->getDifficulty() ?></p>
            </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>

        function loadLesson() {
            for (let i = 0; i < doneLessons.length; i++) {
                let lesson = doneLessons[i];

                // Sprawdź, czy lesson ma właściwość "id" i "color"
                if (lesson && lesson.id && lesson.color) {
                    let element = document.getElementById("lesson" + lesson.id);

                    // Sprawdź, czy element został znaleziony
                    if (element) {
                        element.style.color = lesson.color;
                    } else {
                        console.error("Element not found:", "lesson" + lesson.id);
                    }
                } else {
                    console.error("Invalid lesson data:", lesson);
                }
            }
        }


        loadLesson();
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

