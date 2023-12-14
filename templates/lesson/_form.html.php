<?php
/** @var $lesson ?\App\Model\Lesson */
?>

<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="lesson[title]" value="<?= $lesson ? $lesson->getTitle() : '' ?>">
</div>

<div class="form-group">
    <label for="difficulty">Difficulty</label>
    <input type="text" id="difficulty" name="lesson[difficulty]" value="<?= $lesson ? $lesson->getDifficulty() : '' ?>">
</div>

<div class="form-group">
    <label for="letters">Letters</label>
    <input type="text" id="letters" name="lesson[letters]" value="<?= $lesson ? $lesson->getLetters() : '' ?>">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="lesson[content]"><?= $lesson ? $lesson->getContent() : '' ?></textarea>
</div>

<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
