<?php

require_once '../autoload.php';

use Src\Controllers\AdminController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Admin ID belirtilmedi.']);
    exit;
}

$controller = new AdminController();
echo $controller->deleteAdmin($id);
