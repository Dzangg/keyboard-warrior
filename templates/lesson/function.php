<?php

?>

<script>
    let doneLessons = JSON.parse(localStorage.getItem('data')) || [];

    function setLesson(id, result, accuracy) {
        // Sprawdź, czy doneLessons zawiera lekcję o danym id
        const existingLessonIndex = doneLessons.findIndex(lesson => lesson.id === id);

        if (existingLessonIndex !== -1) {
            // Aktualizuj wynik i kolor dla istniejącej lekcji
            if (doneLessons[existingLessonIndex].accuracy < accuracy) {
                doneLessons[existingLessonIndex].result = result;
                doneLessons[existingLessonIndex].color = getLessonColor(id, result);
                doneLessons[existingLessonIndex].accuracy = accuracy;
            }

        } else {
            // Dodaj nowy wpis do doneLessons
            doneLessons.push({
                id: id,
                result: result,
                accuracy: accuracy,
                color: getLessonColor(id, result)
            });
        }

        // Aktualizuj local storage
        localStorage.setItem('data', JSON.stringify(doneLessons));
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