<?php

namespace App\Model;

use Base\Db;

class User
{
    private $name;
    private $id;
    private $email;
    private $password;
    private $createdAt;

    public function __construct($data = [])
    {
        if ($data) {
            $this->name = $data['name'];
            $this->id = $data['id'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->createdAt = $data['created_at'];
        }
    }

    public function save()
    {
        $db = Db::getInstance();
        $insert = "INSERT INTO users (`name`, `password`, `gender`) VALUES (
            :name, :password, :gender
        )";
        $db->exec($insert, __METHOD__, [
            ':name' => $this->name,
            ':password' => $this->password,
            ':gender' => $this->getGender()
        ]);

        $id = $db->lastInsertId();
        $this->id = $id;

        return $id;
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE id = $id";
        $data = $db->fetchOne($select, __METHOD__);

        if (!$data) {
            return null;
        }

        return new self($data);
    }
}