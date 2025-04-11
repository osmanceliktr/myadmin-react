<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// OPTIONS istekleri için özel işlem - preflight istekleri için gerekli
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header("Content-Type: application/json; charset=UTF-8");

// 1. Gerekli dosyaların yüklenmesi
require_once __DIR__ . '/autoload.php';
require_once 'vendor/autoload.php';

use Src\Controllers\AdminController;
use Src\Controllers\AuthController;

// 2. Genel yapılandırmalar
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. Router Mantığı (Basit)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/api/getAdmins':
        if ($method === 'GET') {
            $controller = new AdminController();
            echo $controller->getAdmins();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'mesaj' => 'Yalnızca GET yöntemi destekleniyor.']);
        }
        break;

    case '/deleteAdmin':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $data['id'] ?? null;

            if ($id) {
                $controller = new AdminController();
                echo $controller->deleteAdmin($id);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'mesaj' => 'Admin ID belirtilmedi.']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'mesaj' => 'Yalnızca POST yöntemi destekleniyor.']);
        }
        break;
    case '/api/loginUser':
        if ($method === 'POST') {
            // Gelen JSON verisini çözümle
            $data = json_decode(file_get_contents('php://input'), true);

            $username = $data['username'] ?? null;
            $password = $data['password'] ?? null;

            $controller = new AuthController();
            echo $controller->login($data);

        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'mesaj' => 'Yalnızca POST yöntemi destekleniyor.']);
        }
        break;
        case '/api/logout':
            if ($method === 'POST') {
                // Gelen JSON verisini çözümle
                $data = json_decode(file_get_contents('php://input'), true);
                $refreshToken = $data['refreshToken'] ?? null;
    
                $controller = new AuthController();
                echo $controller->logout($refreshToken);
            } else {
                http_response_code(405); // Method Not Allowed
                echo json_encode(['success' => false, 'mesaj' => 'Yalnızca POST yöntemi destekleniyor.']);
            }
            break;
    case '/api/refresh':
        if ($method === 'POST') {
            // Gelen JSON verisini çözümle
            $data = json_decode(file_get_contents('php://input'), true);

            $username = $data['username'] ?? null;
            $password = $data['password'] ?? null;

            $controller = new AuthController();
            echo $controller->refresh($data);

        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'mesaj' => 'Yalnızca POST yöntemi destekleniyor.']);
        }
        break;
    default:
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'mesaj' => 'İstek bulunamadı.']);
        break;
}

