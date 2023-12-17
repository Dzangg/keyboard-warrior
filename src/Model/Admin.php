<?php
namespace App\Model;

use App\Service\Config;

class Admin
{
    private ?int $id = null;
    private ?string $username= null;
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }




    public static function fromArray($array): Admin
    {
        $admin = new self();
        $admin->fill($array);
        return $admin;
    }

    public function fill($array): Admin
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['username'])) {
            $this->setUsername($array['username']);
        }
        if (isset($array['password'])) {
            $this->setPassword($array['password']);
        }
        return $this;
    }


//    public static function findAll(): array
//    {
//        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
//        $sql = 'SELECT * FROM admin';
//        $statement = $pdo->prepare($sql);
//        $statement->execute();
//
//        $admins = [];
//        $adminsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
//        foreach ($adminsArray as $adminArray) {
//            $admins[] = self::fromArray($adminArray);
//        }
//
//        return $admins;
//    }

    public static function validateAdmin($username, $password): string
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT id FROM admin WHERE username = :username AND password = :password';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':username' => $username,
            ':password' => $password,
        ]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        // Check if any row was returned (i.e., credentials are valid)
        if ($result && isset($result['id'])) {
            return $username; // Credentials are valid
        }

        return '';
    }


}
