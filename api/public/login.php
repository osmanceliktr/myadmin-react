<?php

require_once '../autoload.php';

use Src\Controllers\AuthController;

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? null;
$password = $data['password'] ?? null;

if (!$username || !$password) {
    echo json_encode(['success' => false, 'message' => 'Kullanıcı adı ve şifre gerekli.']);
    exit;
}

$auth = new AuthController();
echo $auth->login($username, $password);
