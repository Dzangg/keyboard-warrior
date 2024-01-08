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
--
--
-- --add sample data to lesson table
--
-- INSERT INTO lesson (title, difficulty, letters, content) VALUES
--                                                              ('Lesson 1', 'Easy', 'abc', 'cba abb bba cac'),
--                                                              ('Lesson 2', 'Medium', 'efg', 'eee fff ggg gfa gfe'),
--                                                              ('Lesson 3', 'Hard', 'hij', 'hhh iii jjj jih jhi'),
--                                                              ('Lesson 4', 'Easy', 'klm', 'kkl lmk mkk kml'),
--                                                              ('Lesson 5', 'Medium', 'nop', 'nno ppo opp onp'),
--                                                              ('Lesson 6', 'Hard', 'qrs', 'qqq sss rrr srq'),
--                                                              ('Lesson 7', 'Easy', 'tuv', 'ttt uuu vvv vtu'),
--                                                              ('Lesson 8', 'Medium', 'wxy', 'www xwx ywy yxw'),
--                                                              ('Lesson 9', 'Hard', 'zab', 'zzz aaa bbb baz'),
--                                                              ('Lesson 10', 'Easy', 'cde', 'ccc ddd eee edc'),
--                                                              ('Lesson 11', 'Medium', 'fgh', 'fff ggg hhh hgf'),
--                                                              ('Lesson 12', 'Hard', 'ijk', 'iii jjj kkk kji');
