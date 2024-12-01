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
        $stmt = $this->db->prepare("SELECT * FROM kullanicilar");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($result as $row) {
            $users[] = new User($row['id'], $row['kullaniciadi'], $row['adisoyadi'], $row['sifre']);
        }
        return $users;
    }

    public function deleteById(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM kullanicilar WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById(string $id) {
        $stmt = $this->db->prepare("SELECT * FROM kullanicilar WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['kullaniciadi'], $user['adisoyadi'], $user['sifre']);
        }

        return null;
	}
	
	public function getByUser(string $kullaniciadi) {
        $stmt = $this->db->prepare("SELECT * FROM kullanicilar WHERE kullaniciadi = :kullaniciadi");
        $stmt->bindParam(':kullaniciadi', $kullaniciadi, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User($user['id'], $user['kullaniciadi'], $user['adisoyadi'], $user['sifre']);
        }

        return null;
	}
    public function findUserByCredentials($kullaniciadi, $sifre)
    {
        $stmt = $this->db->prepare("SELECT * FROM kullanicilar WHERE kullaniciadi = :kullaniciadi");
        $stmt->bindParam(':kullaniciadi', $kullaniciadi, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kullanıcı bulunduysa şifre doğrulaması
        if ($user && password_verify($sifre, $user['sifre'])) {
            return new User($user['id'], $user['kullaniciadi'], $user['adisoyadi'], $user['sifre']);
        }

        return null;
    }
}
