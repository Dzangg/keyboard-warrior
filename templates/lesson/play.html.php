<?php

/** @var \App\Model\Lesson $lesson */
/** @var \App\Service\Router $router */

include 'function.php';

$title = "Lesson {$lesson->getId()}";
$bodyClass = 'index';

ob_start(); ?>

    <audio id="keyPressAudio">
        <source src="/assets/media/keyb.mp3" type="audio/mpeg">
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
    <p id="typingSpeedDisplay"></p>
    <div id="typingSpeedBarContainer">
        <div id="typingSpeedBar"></div>
    </div>
    <div class="test">
        <div class="keyboard">
            <div class="row">
                <div class="color-options">
                    <h2>Keyboard background:</h2>
                    <input class="keyboard-color-input" type="color">
                    <h2>Key background color:</h2>
                    <input class="key-color-input" type="color">
                </div>
            </div>
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
        </div>
    </div>

    <div id="startOverlay" class="overlay start-overlay">
        <div id="modal" class="modal">
            Press any key to start
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
                this.showStartOverlay();
                this.applyCurrentStyle(this.currentPosition);

                document.addEventListener('keydown', (event) => {
                    if (this.isFinished) {
                        return;
                    }

                    if (!this.isStarted) {
                        this.hideStartOverlay();
                        this.isStarted = true;
                        actualData = Date.now();
                    }

                    if (this.firstKeyPress) {
                        this.firstKeyPress = false;
                        return; // Ignore the first key press
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
                setLesson(lessonId, result, this.accuracyResult);
            }

            showStartOverlay() {
                const startOverlay = document.getElementById('startOverlay');
                startOverlay.style.display = 'flex';

                // Dodaj obsługę kliknięcia na overlay tylko wtedy, gdy jest widoczny
                startOverlay.addEventListener('click', () => {
                    this.hideStartOverlay();
                });

                document.addEventListener('keydown', () => {
                    this.hideStartOverlay();
                });
            }

            hideStartOverlay() {
                const startOverlay = document.getElementById('startOverlay');
                startOverlay.style.display = 'none';
            }

            showOverlay() {
                let overlay = document.getElementById('overlay');
                overlay.style.display = 'flex';
                document.body.style.backgroundColor = 'rgba(0, 0, 0, 0.2)';

                // Dodaj obsługę kliknięcia na tło overlay tylko wtedy, gdy jest widoczne
                overlay.addEventListener('click', (event) => {
                    if (event.target === document.getElementById('overlay')) {
                        this.hideOverlay();
                    }
                });
            }

            hideOverlay() {
                let overlay = document.getElementById('overlay');
                overlay.style.display = 'none';
                document.body.style.backgroundColor = ''; // Przywróć kolor tła
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
            document.getElementById('keyPressAudio').play();

            for (let i = 0; i < keys.length; i++) {
                if (event.key === " ") {
                    event.preventDefault();
                }

                if (event.key.toLowerCase() === keys[i].textContent.toLowerCase() || event.code.toLowerCase() === keys[i].textContent.toLowerCase()) {
                    const originalColor = keys[i].style.backgroundColor;

                    keys[i].style.backgroundColor = 'white';
                    keys[i].style.transition = 'background-color 0.3s ease';

                    setTimeout(() => {
                        keys[i].style.transition = 'background-color 0.3s ease';
                        keys[i].style.backgroundColor = originalColor;
                    }, 150);
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            let keyboardColorInput = document.querySelector('.keyboard-color-input');
            let keyColorInput = document.querySelector('.key-color-input');
            let keyboard = document.querySelector('.keyboard');
            let keys = document.querySelectorAll('.key');

            // Load colors from localStorage
            let savedKeyboardColor = localStorage.getItem('keyboardColor');
            let savedKeyColor = localStorage.getItem('keyColor');

            if (savedKeyboardColor) {
                keyboard.style.backgroundColor = savedKeyboardColor;
                keyboardColorInput.value = savedKeyboardColor; // Update the color picker value
            }

            if (savedKeyColor) {
                keys.forEach(function(key) {
                    key.style.backgroundColor = savedKeyColor;
                });
                keyColorInput.value = savedKeyColor; // Update the color picker value
            }

            // Save keyboard color to localStorage
            keyboardColorInput.addEventListener('input', function() {
                let selectedColor = keyboardColorInput.value;
                keyboard.style.backgroundColor = selectedColor;
                localStorage.setItem('keyboardColor', selectedColor);
            });

            // Save key color to localStorage
            keyColorInput.addEventListener('input', function() {
                let selectedKeyColor = keyColorInput.value;
                keys.forEach(function(key) {
                    key.style.backgroundColor = selectedKeyColor;
                });
                localStorage.setItem('keyColor', selectedKeyColor);
            });
        });




        document.addEventListener('DOMContentLoaded', function() {
            // Pobierz litery z lesson-letters
            let lessonLetters = '<?= $lesson->getLetters() ?>';
            let lessonLettersArray = lessonLetters.split('');

            // Pobierz wszystkie klawisze na klawiaturze
            let keys = document.querySelectorAll('.key');

            // Dodaj klasę highlight do klawiszy odpowiadających literom z lesson-letters
            lessonLettersArray.forEach(function(letter) {
                keys.forEach(function(key) {
                    if (key.textContent.toLowerCase() === letter.toLowerCase()) {
                        key.classList.add('highlight');
                    }
                });
            });
        });









        let keyPressTimes = 0;
        let actualData = Date.now();
        let typingSpeedBar = document.getElementById("typingSpeedBar");
        let decreaseSpeedInterval;

        function calculateTypingSpeed() {
            if (!lessonInstance.isStarted) {
                return 0; // Jeśli lekcja się nie rozpoczęła, zwróć 0
            }

            let newData = (Date.now() - actualData) / 1000;
            if (newData === 0) {
                return 0; // Aby uniknąć dzielenia przez zero
            }

            keyPressTimes += 1;
            const typingSpeed = keyPressTimes / newData;
            return typingSpeed;
        }


        function updateTypingSpeedDisplay() {
            if(lessonInstance.isFinished){
                return;
            }
            const speed = calculateTypingSpeed();
            const displayElement = document.getElementById("typingSpeedDisplay");

            let color;

            if (speed >= 5) {
                color = "green";
            } else if (speed >= 2) {
                color = "#b86e14";
            } else {
                color = "red";
            }

            displayElement.textContent = `Current typing speed: ${speed.toFixed(2)} keys per second`;
            displayElement.style.color = color;

            // Sprawdź, czy szerokość paska jest ustawiona
            if (typingSpeedBar.style.width === "inf") {
                typingSpeedBar.style.width = "0%";
            }

            // Update progress bar dynamically
            const maxSpeed = 5; // Maksymalna prędkość, na której pasek będzie pełen
            const percentage = (speed / maxSpeed) * 100;
            typingSpeedBar.style.width = `${Math.max(percentage, 0)}%`; // Niech pasek nie spada poniżej zera
            typingSpeedBar.style.backgroundColor = (percentage >= 100) ? "green" : color;
        }

        function decreaseTypingSpeed() {
            if (lessonInstance.isFinished) {
                clearInterval(decreaseSpeedInterval); // Zatrzymaj interval, jeśli lekcja się zakończyła
                return;
            }

            const currentWidth = parseFloat(typingSpeedBar.style.width) || 0;
            if (currentWidth > 0) {
                typingSpeedBar.style.width = `${Math.max(currentWidth - 0.1, 0)}%`;
            }
        }


        function onKeyPress(event) {
            if (!lessonInstance.isStarted) {
                lessonInstance.isStarted = true;
                actualData = Date.now();
                keyPressTimes = 0;
            }
            updateTypingSpeedDisplay();
            // Reset interval
            clearInterval(decreaseSpeedInterval);
            decreaseSpeedInterval = setInterval(decreaseTypingSpeed, 100); // 100 milliseconds interval
        }

        document.addEventListener("keydown", onKeyPress);

        // Inicjalizacja prędkościomierza na 0
        updateTypingSpeedDisplay();

        // Dodana funkcja aktualizująca prędkość dynamicznie
        setInterval(updateTypingSpeedDisplay, 1000);
    </script>

<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';