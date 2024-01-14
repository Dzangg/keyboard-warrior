<?php

?>

<script>
    let doneCustomLessons = JSON.parse(localStorage.getItem('lessons')) || [];

    function setLesson(id, result, accuracy) {
        // Sprawdź, czy doneLessons zawiera lekcję o danym id
        const existingLessonIndex = doneCustomLessons.findIndex(lesson => lesson.id === id);
        if (existingLessonIndex !== -1) {
            if (!doneCustomLessons[existingLessonIndex].accuracy) {
                doneCustomLessons[existingLessonIndex].result = result;
                doneCustomLessons[existingLessonIndex].color = getLessonColor(id, result);
                doneCustomLessons[existingLessonIndex].accuracy = accuracy;

            }
            // Aktualizuj wynik i kolor dla istniejącej lekcji
            else if (doneCustomLessons[existingLessonIndex].accuracy < accuracy) {
                doneCustomLessons[existingLessonIndex].result = result;
                doneCustomLessons[existingLessonIndex].color = getLessonColor(id, result);
                doneCustomLessons[existingLessonIndex].accuracy = accuracy;
            }

        } else {
            // Dodaj nowy wpis do doneLessons
            doneCustomLessons.push({
                id: id,
                result: result,
                accuracy: accuracy,
                color: getLessonColor(id, result)
            });
        }

        // Aktualizuj local storage
        localStorage.setItem('lessons', JSON.stringify(doneCustomLessons));
    }

    function getLessonColor(id, result) {
        // Default color is red
        let color = 'red';

        // Check if the result is "completed!" and set color to green
        if (result === "completed!") {
            color = 'green';
        }

        return color;
    }
</script>
