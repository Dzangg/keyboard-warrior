create table if not exists lesson
(
    id      integer not null
        constraint lesson_pk
            primary key autoincrement,
    title text not null,
    difficulty text not null,
    letters text not null,
    content text not null
);

create table if not exists admin
(
    id       integer not null
        constraint admin_pk
            primary key autoincrement,
    username text    not null,
    password text    not null
);

-- insert into admin (username, password) values ('admin', 'admin');


-- add sample data to lesson table
-- insert into lesson (title, difficulty, letters, content) values ('Lesson 1', 'Easy', 'abc', 'cba abb bba cac');
-- add sample data to lesson table
-- insert into lesson (title, difficulty, letters, content) values ('Lesson 2', 'Medium', 'efg', 'eee fff ggg gfa gfe');