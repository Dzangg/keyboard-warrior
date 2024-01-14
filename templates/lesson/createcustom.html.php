<?php

/** @var \App\Service\Router $router */

$title = 'Create Lesson';
$bodyClass = "edit";

ob_start(); ?>
<h1>Create your custom lesson</h1>


<form id="create-lesson-form">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="lesson[title]">
    </div>

    <div class="form-group">
        <label for="difficulty">Difficulty</label>
        <input type="text" id="difficulty" name="lesson[difficulty]">
    </div>

    <div class="form-group">
        <label for="letters">Letters</label>
        <input type="text" id="letters" name="lesson[letters]"">
    </div>

    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" name="lesson[content]"></textarea>
    </div>

    <div class="form-group">
        <button type="button" onclick="saveLesson()">Save</button>
    </div>


</form>

<a href="<?= $router->generatePath('lesson-index') ?>">Back to list</a>


<script>
    function saveLesson() {


        // Get existing lessons from local storage or initialize an empty array
        var lessons = JSON.parse(localStorage.getItem('lessons')) || [];

        var lesson = {
            id: lessons.length + 1,
            name: document.getElementById('title').value,
            letters: document.getElementById('letters').value,
            content: document.getElementById('content').value,
            difficulty: document.getElementById('difficulty').value
        };

        // Add the new lesson to the array
        lessons.push(lesson);

        // Save the updated lessons array back to local storage
        localStorage.setItem('lessons', JSON.stringify(lessons));

        // Redirect to the lesson index page or perform any other action
        window.location.href = '<?= $router->generatePath('lesson-index') ?>';
    }
</script>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';

?>
