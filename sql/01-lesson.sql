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
--                                                              ('Lesson 13', 'Easy', 'abc', 'cba abb bba cac cac cac cac cac cba abb bba cac cac cac cac cac');
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
-- max 60 literek


INSERT INTO lesson (title, difficulty, letters, content) VALUES
                                                             ('Lesson 1', 1, 'lkq', 'lkq qql kkk lkq'),
                                                             ('Lesson 2', 1, 'klm', 'kkl lmk mkk kml'),
                                                             ('Lesson 3', 1, 'nop', 'nno ppo opp onp'),
                                                             ('Lesson 4', 1, 'qrs', 'qqq sss rrr srq'),
                                                             ('Lesson 5', 1, 'tuv', 'ttt uuu vvv vtu'),
                                                             ('Lesson 6', 1, 'wxy', 'www xwx ywy yxw'),
                                                             ('Lesson 7', 2, 'efgrt', 'gefrr tfeet feggr ffgrt'),
                                                             ('Lesson 8', 2, 'hijop', 'joih hopi ioph hpji'),
                                                             ('Lesson 9', 2, 'lzubs', 'luzb blsu zbul lusb'),
                                                             ('Lesson 10', 2, 'alrmcy', 'acmry alrmc rmyal clyma'),
                                                             ('Lesson 11', 2, 'qorvu', 'vqoru oqrvu qourv uvqro'),
                                                             ('Lesson 12', 3, 'omencusz', 'snecozmu uzsoecmn mecsonzu cmzosec'),
                                                             ('Lesson 13', 3, 'laytsmeo', 'tsoeymal ametsloy etlyosam tollmym');



