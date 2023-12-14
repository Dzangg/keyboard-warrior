create table lesson
(
    id      integer not null
        constraint lesson_pk
            primary key autoincrement,
    title text not null,
    difficulty text not null,
    letters text not null
);
