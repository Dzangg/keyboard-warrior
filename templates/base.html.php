<?php

// Pobierz akcję z adresu URL
$action = $_GET['action'] ?? '';

// Jeśli akcja to "admin", kontynuuj renderowanie strony

// Reszta kodu w pliku base.html.php

/** @var string $title */
/** @var string $bodyClass */
/** @var string $main */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/dist/style.min.css">
<!--    <script type="text/javascript" src="../local.js"></script>-->

</head>
<body <?= isset($bodyClass) ? "class='$bodyClass'" : '' ?>>
<nav><?php require(__DIR__ . DIRECTORY_SEPARATOR . 'nav.html.php') ?></nav>
<main><?= $main ?? null ?></main>
<footer>&copy;<?= date('Y') ?> Custom Framework</footer>
</body>
</html>


<script>
    let doneLessons = JSON.parse(localStorage.getItem('data')) || [];

    function loadLesson() {
        for (let i = 0; i < doneLessons.length; i++) {
            let element = document.getElementById("lesson" + doneLessons[i]);
            element.style.color = 'red';
        }
    }

    function setLesson(id) {
        if (doneLessons.includes(id)) {
            return;
        }
        localStorage.setItem('data', JSON.stringify([...doneLessons, id]));
    }

    setLesson(2);
    loadLesson();
</script>

?>