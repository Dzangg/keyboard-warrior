<?php

/** @var \App\Model\Lesson $lesson */
/** @var \App\Service\Router $router */

$title = "Lesson {$lesson->getId()}";
$bodyClass = 'index';

ob_start(); ?>
    <h1>Lesson <?= $lesson->getId() ?> </h1>

    <h2>Difficulty:  <?= $lesson->getDifficulty() ?> </h2>
    <h2>Learning letters:  <?= $lesson->getLetters() ?> </h2>

<?php
$contentArray = str_split($lesson->getContent());

// Counter variable for generating unique IDs
$counter = 1;

foreach ($contentArray as $item) {
    $itemId = 'character' . $counter;
    echo '<span  id="' . $itemId . '">' . $item . '</span>';
    $counter++;
}
?>


    <p><a href="<?= $router->generatePath('lesson-index') ?>">Back to lessons</a></p>


    <script>
        let lessonContent = <?= json_encode($lesson->getContent()) ?>;
        lessonContent = lessonContent.split('');
        let currentPosition = 1;
        let mistakesCount = 0;
        let isFinished = false;
        applyCurrentStyle(currentPosition);

        document.addEventListener('keydown', function(event) {
            if (isFinished) {
                return;
            }

            const properKeyName = lessonContent[currentPosition - 1];
            // console.log(lessonContent.slice(0,currentPosition+1));

            if (event.key === properKeyName) {
                validate(currentPosition, true);
                currentPosition++;
                if (currentPosition === lessonContent.length + 1) {
                    lessonCompleted();
                }
            } else {
                console.log('Wrong key pressed!');
                validate(currentPosition, false);
                currentPosition++;

                mistakesCount++;
                if (currentPosition === lessonContent.length + 1) {
                    lessonCompleted();
                }
            }
            applyCurrentStyle(currentPosition);
        });

        function applyCurrentStyle(position) {
            if (position <= lessonContent.length) {
                const characterId = 'character' + position;
                const characterElement = document.getElementById(characterId);
                characterElement.classList.add('current');
            }
            if (position > 1) {
                const previousCharacterId = 'character' + (position - 1);
                const previousCharacterElement = document.getElementById(previousCharacterId);
                previousCharacterElement.classList.remove('current');
            }
        }

        function validate(position, isValid) {
            const characterId = 'character' + position;
            const characterElement = document.getElementById(characterId);

            if (isValid) {
                characterElement.classList.add('valid');
            } else {
                characterElement.classList.add('invalid');
            }
        }

        function lessonCompleted() {
            isFinished = true;
            console.log('Lesson completed!')
            console.log('Mistakes count: ' + mistakesCount)
            console.log('Accuracy: ' + (lessonContent.length - mistakesCount) / lessonContent.length * 100 + '%')
        }

    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
