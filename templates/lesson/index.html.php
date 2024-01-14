<?php

/** @var \App\Model\Lesson[] $lessons */
/** @var \App\Service\Router $router */

include 'function.php';
include 'functionCustom.php';


$title = 'Lesson List';
$bodyClass = 'index';

ob_start(); ?>
    <h1>Lessons List</h1>

    <div class="statistic-container">
        <p>Your statistics:</p>
        <p id="done-lessons"></p>
        <p id="lessons-accuracy"></p>
    </div>

    <ul class="index-list">
        <?php
        $lessonCounter = 1; // Initialize the counter before the loop
        foreach ($lessons as $lesson):
            ?>
            <li>
                <a href="<?= $router->generatePath('lesson-play',  ['id' => $lesson->getId()]) ?>">
                    <h3 id="lesson<?= $lesson->getId() ?>">Title: <?= $lesson->getTitle() ?></h3>
                    <p>Difficulty: <?= $lesson->getDifficultyString() ?></p>
                </a>
            </li>
            <?php
            $lessonCounter++; // Increment the counter for the next lesson
        endforeach;
        ?>
    </ul>



    <hr>
<div id="custom-lesson-container">
    <p class="custom-lesson-link"><a href="<?= $router->generatePath('lesson-custom-create') ?>">Create your custom lesson</a></p>
    <ul class="index-list" id="custom-list">
    </ul>
</div>





    <script>
        function markLessons() {
            if (doneLessons.length > 0 || doneCustomLessons.length > 0) {
                let doneLessons = JSON.parse(localStorage.getItem('data')) || [];
                let accuracys = [];
                for (let i = 0; i < doneLessons.length; i++) {
                    accuracys.push(doneLessons[i].accuracy);
                }
                for (let i = 0; i < doneCustomLessons.length; i++) {
                    if (doneCustomLessons[i].accuracy) {
                        accuracys.push(doneCustomLessons[i].accuracy);
                    }
                }
                let averageAccuracy = accuracys.reduce((a, b) => a + b, 0) / accuracys.length;

                let doneLessonsCnt = document.getElementById('done-lessons');
                let lessonsAccuracy = document.getElementById('lessons-accuracy');
                let actuallyDone = doneCustomLessons.filter(lesson => lesson.accuracy);
                console.log(actuallyDone.length)

                doneLessonsCnt.innerText = "Done lessons: " + (doneLessons.length + actuallyDone.length);
                lessonsAccuracy.innerText = "Average accuracy: " + averageAccuracy.toString().substring(0,5) + "%";
            } else {
                let doneLessonsCnt = document.getElementById('done-lessons');
                let lessonsAccuracy = document.getElementById('lessons-accuracy');
                doneLessonsCnt.innerText = "Done lessons: 0";
                lessonsAccuracy.innerText = "Average accuracy: 0%";
            }

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

            for (let i = 0; i < doneCustomLessons.length; i++) {
                let lesson = doneCustomLessons[i];
                // Sprawdź, czy lesson ma właściwość "id" i "color"
                if (lesson && lesson.id && lesson.color) {
                    let element = document.getElementById("custom-lesson" + lesson.id);
                    // Sprawdź, czy element został znaleziony
                    if (element) {
                        element.style.color = lesson.color;
                    } else {
                        console.error("Element not found:", "lesson" + lesson.id);
                    }
                }
            }
        }

        function loadCustomLessons() {

            var lessons = JSON.parse(localStorage.getItem('lessons')) || [];
            var list = document.getElementById('custom-list');
            for (let i = 0; i < lessons.length; i++) {
                let lesson = lessons[i];
                let li = document.createElement('li');
                let a = document.createElement('a');
                a.href = "<?= $router->generatePath('lesson-custom-play', [
                        'lessonId' => 'id',
                    'lessonTitle' => 'title',
                    'lessonLetters' => 'letters',
                    'lessonDifficulty' => 'difficulty',
                    'lessonContent' => 'content',
                    ]) ?>".replace('id', (i+1)).replace('title', lesson.name).replace('letters', lesson.letters)
                    .replace('difficulty', lesson.difficulty).replace('content', lesson.content);
                let h3 = document.createElement('h3');
                let p = document.createElement('p');
                let title = document.createTextNode('Title: ' + lesson.name);
                let difficulty = document.createTextNode('Difficulty: ' + lesson.difficulty);
                let id = document.createAttribute('id');
                id.value = 'custom-lesson' + (i+1);
                h3.setAttributeNode(id);
                h3.appendChild(title);
                p.appendChild(difficulty);
                a.appendChild(h3);
                a.appendChild(p);
                li.appendChild(a);
                list.appendChild(li);
           }
            if (lessons.length > 0) {
                let customContainer = document.getElementById('custom-lesson-container');
                let div = document.createElement('div');
                div.classList.add('custom-lesson-button-container');
                let button = document.createElement('button');
                button.type = 'button';
                button.innerText = 'Delete all custom lessons';
                button.classList.add('custom-lesson-button');
                button.onclick = function () {
                    localStorage.removeItem('lessons');
                    location.reload();
                }
                div.appendChild(button);
                customContainer.appendChild(div);
            }

        }

        window.onload = () => {
            loadCustomLessons();
            markLessons();
        }
    </script>




<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

