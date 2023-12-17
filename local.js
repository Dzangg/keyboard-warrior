let user = {
    doneLessons: [1, 2],
    lessons: [],
    load: function () {
        const localDoneLessons = localStorage.getItem('doneLessons');
        if (localDoneLessons) {
            user.doneLessons = JSON.parse(localDoneLessons);
        }
        let numLessons = 3;
        for (let i = 1; i <= numLessons; i++) {
            const lesson = document.getElementById(`lesson${i}`);
            if (user.doneLessons.includes(i)) {
                let text = document.createTextNode("-done")
                lesson.appendChild(text);
            }
        }
    },
    lessonComplete: function () {
        let currentLesson = 1;
        if ("Lekcja udana") {
            console.log('hello');
            user.doneLessons.push(currentLesson);
            localStorage.setItem('doneLessons', JSON.stringify(user.doneLessons));
        }
    },
}

// user.load();
user.lessonComplete();