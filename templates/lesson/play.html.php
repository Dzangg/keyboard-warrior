<?php

/** @var \App\Model\Lesson $lesson */
/** @var \App\Service\Router $router */

$title = "Lesson {$lesson->getId()}";
$bodyClass = 'index';

ob_start(); ?>
    <audio id="keyPressAudio">

        <source src="keyb.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
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
<div class="test">
    <div class="keyboard">
        <div class="row">
            <div class="key">`</div>
            <div class="key">1</div>
            <div class="key">2</div>
            <div class="key">3</div>
            <div class="key">4</div>
            <div class="key">5</div>
            <div class="key">6</div>
            <div class="key">7</div>
            <div class="key">8</div>
            <div class="key">9</div>
            <div class="key">0</div>
            <div class="key delete">DELETE</i></div>
        </div>
        <div class="row">
            <div class="key tab">TAB</div>
            <div class="key">Q</div>
            <div class="key">W</div>
            <div class="key">E</div>
            <div class="key">R</div>
            <div class="key">T</div>
            <div class="key">Y</div>
            <div class="key">U</div>
            <div class="key">I</div>
            <div class="key">O</div>
            <div class="key">P</div>
            <div class="key">[</div>
            <div class="key">]</div>
            <div class="key">\</div>
        </div>
        <div class="row">
            <div class="key capslock">CAPSLOCK</div>
            <div class="key">A</div>
            <div class="key">S</div>
            <div class="key">D</div>
            <div class="key">F</div>
            <div class="key">G</div>
            <div class="key">H</div>
            <div class="key">J</div>
            <div class="key">K</div>
            <div class="key">L</div>
            <div class="key">;</div>
            <div class="key">'</div>
            <div class="key enter">ENTER</div>
        </div>
        <div class="row">
            <div class="key left shift">SHIFT</div>
            <div class="key">Z</div>
            <div class="key">X</div>
            <div class="key">C</div>
            <div class="key">V</div>
            <div class="key">B</div>
            <div class="key">N</div>
            <div class="key">M</div>
            <div class="key">,</div>
            <div class="key">.</div>
            <div class="key">/</div>
            <div class="key left shift">SHIFT</div>
        </div>
        <div class="row">
            <div class="key ctrl">CTRL</div>
            <div class="key alt">ALT</div>
            <div class="key space">SPACE</div>
            <div class="key alt">ALT</div>
            <div class="key ctrl">CTRL</div>
        </div>
    </div>
</div>


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


        let keyboard = document.getElementsByClassName('keyboard')[0];
        let keys = keyboard.getElementsByClassName('key');

        document.addEventListener('keydown', (event) => {
            for (let i = 0; i < keys.length; i++) {
                if (event.key.toLowerCase() === keys[i].textContent.toLowerCase()) {
                    keys[i].style.backgroundColor = 'red';
                    keys[i].style.transition = 'background-color 0.3s ease';

                    // Odtwarzaj dźwięk za pomocą elementu audio
                    document.getElementById('keyPressAudio').play();
                    console.log('cos')
                    document.addEventListener('keyup', (event) => {
                        keys[i].style.backgroundColor = '';
                        keys[i].style.transition = 'background-color 0.9s ease';
                    });
                }
            }
        });
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
