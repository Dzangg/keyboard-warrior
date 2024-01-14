<?php
namespace App\Model;

use App\Service\Config;

class Lesson
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $difficulty = null;
    private ?string $letters = null;
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getLetters(): ?string
    {
        return $this->letters;
    }

    public function setLetters(?string $letters): void
    {
        $this->letters = $letters;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getDifficultyString(): string
    {
        switch ($this->getDifficulty()) {
            case 1:
                return 'Easy';
            case 2:
                return 'Medium';
            case 3:
                return 'Hard';
            default:
                return 'Unknown';
        }
    }

    public static function fromArray($array): Lesson
    {
        $lesson = new self();
        $lesson->fill($array);

        return $lesson;
    }

    public function fill($array): Lesson
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['difficulty'])) {
            $this->setDifficulty($array['difficulty']);
        }
        if (isset($array['letters'])) {
            $this->setLetters($array['letters']);
        }
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }
        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM lesson';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $lessons = [];
        $lessonsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($lessonsArray as $lessonArray) {
            $lessons[] = self::fromArray($lessonArray);
        }

        return $lessons;
    }

    public static function findAllSortedByDifficulty(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM lesson ORDER BY difficulty ASC'; // You can adjust ASC to DESC if needed
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $lessons = [];
        $lessonsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($lessonsArray as $lessonArray) {
            $lessons[] = self::fromArray($lessonArray);
        }

        return $lessons;
    }


    public static function find($id): ?Lesson
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM lesson WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $lessonArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $lessonArray) {
            return null;
        }
        $lesson = Lesson::fromArray($lessonArray);

        return $lesson;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO lesson (title, difficulty, letters, content) VALUES (:title, :difficulty, :letters, :content)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'difficulty' => $this->getDifficulty(),
                'letters' => $this->getLetters(),
                'content' => $this->getContent(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE lesson SET title = :title, difficulty = :difficulty, letters = :letters, content = :content WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':title' => $this->getTitle(),
                ':difficulty' => $this->getDifficulty(),
                ':letters' => $this->getLetters(),
                ':content' => $this->getContent(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM lesson WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setTitle(null);
        $this->setDifficulty(null);
        $this->setLetters(null);
        $this->setContent(null);
    }
}
