<?php

namespace Src\Repositories;

use Config\Database;
use Src\Models\User;
use PDO;

class UserRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($result as $row) {
            $users[] = new User($row['id'], $row['username'], $row['nameSurname'], $row['password']);
        }
        return $users;
    }

    public function deleteById(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById(string $id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['username'], $user['nameSurname'], $user['password']);
        }

        return null;
	}
	
	public function getByUser(string $username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['username'], $user['nameSurname'], $user['password']);
        }

        return null;
	}
    public function findUserByCredentials($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kullanıcı bulunduysa şifre doğrulaması
        if ($user && password_verify($password, $user['password'])) {
            return new User($user['id'], $user['username'], $user['nameSurname'], $user['password']);
        }

        return null;
    }
}
