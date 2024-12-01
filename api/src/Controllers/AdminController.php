<?php

namespace Src\Controllers;

use Src\Repositories\UserRepository;

class AdminController {
    private $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepository();
    }
    public function getAdmins() {
        $users = $this->userRepo->getAll();
        if (!empty($users)) {
            return json_encode(['success' => true, 'users' => $users]);
        }
        return json_encode(['success' => false, 'mesaj' => 'Veri bulunamadı!']);
    }
    public function deleteAdmin($id) {
        if ($this->userRepo->deleteById($id)) {
            return json_encode(['success' => true, 'mesaj' => 'Admin başarıyla silindi.']);
        }
        return json_encode(['success' => false, 'mesaj' => 'Admin silinirken bir hata oluştu.']);
    }
}
