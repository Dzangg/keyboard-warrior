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

<div class="lesson-info">
    <h1 class="lesson-name">Lesson <?= $lesson->getId() ?> </h1>
    <h2 class="lesson-difficulty">Difficulty:  <?= $lesson->getDifficulty() ?> </h2>
    <h2 class="lesson-letters">Learning letters:  <?= $lesson->getLetters() ?> </h2>

</div>

<?php
$contentArray = str_split($lesson->getContent());

// Counter variable for generating unique IDs
$counter = 1;
echo '<div class="lesson-content">';

foreach ($contentArray as $item) {
    // Check if $item is whitespace and replace it with &nbsp;
    $itemContent = ($item === ' ') ? '&nbsp;' : $item;

    $itemId = 'character' . $counter;
    echo '<div class="lesson-letter-container" id="container' . $counter .'">';
    echo '<p class="lesson-letter" id="' . $itemId . '">' . $itemContent . '</p>';
    echo '</div>';
    $counter++;
}
echo '</div>';
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

    <div id="overlay" class="overlay">
        <div id="modal" class="modal">
            <p>Lesson <span id="result"></span> <br> Mistakes count: <span id="mistakesCount"></span> <br>Accuracy: <span id="accuracy"></span>%</p>
            <p><a href="<?= $router->generatePath('lesson-index') ?>">Back to lessons</a></p>
        </div>
    </div>



    <p class="back-link"><a href="<?= $router->generatePath('lesson-index') ?>">Back to lessons</a></p>


    <script>
        class Lesson {
            constructor(content) {
                this.lessonContent = content.split('');
                this.currentPosition = 1;
                this.mistakesCount = 0;
                this.accuracyResult = 0;
                this.finalResultLesson = 0;
                this.isFinished = false;
                this.initializeLesson();
            }

            initializeLesson() {
                this.applyCurrentStyle(this.currentPosition);

                document.addEventListener('keydown', (event) => {
                    if (this.isFinished) {
                        return;
                    }

                    const properKeyName = this.lessonContent[this.currentPosition - 1];

                    if (event.key === properKeyName) {
                        this.validate(true);
                        this.currentPosition++;

                        if (this.currentPosition === this.lessonContent.length + 1) {
                            this.lessonCompleted();
                        }
                    } else {
                        console.log('Wrong key pressed!');
                        this.validate(false);
                        this.currentPosition++;

                        this.mistakesCount++;

                        if (this.currentPosition === this.lessonContent.length + 1) {
                            this.lessonCompleted();
                        }
                    }
                    this.applyCurrentStyle(this.currentPosition);
                });
            }

            applyCurrentStyle(position) {
                if (position <= this.lessonContent.length) {
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

            validate(isValid) {
                const characterId = 'character' + this.currentPosition;
                const containerName = 'container' + this.currentPosition;
                const characterElement = document.getElementById(containerName);

                if (isValid) {
                    characterElement.classList.add('valid');
                } else {
                    characterElement.classList.add('invalid');
                }
            }

            lessonCompleted() {
                this.isFinished = true;

                // Show the modal overlay
                this.showOverlay();
                this.Accuracy();
                this.resultLesson();

                // Update modal content
                document.getElementById('mistakesCount').innerText = this.mistakesQuantity();
                document.getElementById('accuracy').innerText = this.Accuracy();
                document.getElementById('result').innerText = this.resultLesson();

                // Set lesson color
                const lessonId = <?= $lesson->getId() ?>; // Fetch lesson ID from PHP
                const result = this.resultLesson();
                console.log(result);
                // Set lesson color using setLesson function
                setLesson(lessonId, result);
            }

            showOverlay() {
                var overlay = document.getElementById('overlay');
                overlay.style.display = 'flex';
                document.body.style.backgroundColor = 'rgba(0, 0, 0, 0.2)';
            }

            mistakesQuantity() {
                return this.mistakesCount;
            }

            Accuracy() {
                this.accuracyResult = ((this.lessonContent.length - this.mistakesCount) / this.lessonContent.length * 100)
                return this.accuracyResult;
            }

            resultLesson() {
                if (this.accuracyResult > 50) {
                    this.finalResultLesson = "completed!";
                    return this.finalResultLesson;
                }
                this.finalResultLesson = "failed!";
                return this.finalResultLesson;
            }
        }

        // Create an instance of the Lesson class with the lesson content
        const lessonInstance = new Lesson(<?= json_encode($lesson->getContent()) ?>);

        // keyboard handler
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
