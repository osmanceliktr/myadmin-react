<?php

namespace Src\Controllers;

use Src\Repositories\UserRepository;
use Src\Services\JWTService;

class AuthController {
    private $userRepo;
    private $jwtService;

    public function __construct() {
        $this->userRepo = new UserRepository();
        $this->jwtService = new JWTService();
    }
    public function login($request)
    {
        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;

        if (!$username || !$password) {
            return json_encode(['success' => false,'error' => 'Kullanıcı adı veya şifre eksik'], JSON_PRETTY_PRINT);
        }

        $user = $this->userRepo->findUserByCredentials($username, $password);

        if ($user) {
            $accessToken = $this->jwtService->createAccessToken($user->id);
            $refreshToken = $this->jwtService->createRefreshToken($user->id);

            return json_encode([
                'accessToken' => $accessToken,
                'refreshToken' => $refreshToken,
            ]);
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        return json_encode(['success' => false,'error' => 'Kullanıcı adı veya şifre hatalı','pass'=>$hashedPassword], JSON_PRETTY_PRINT);
    }
    public function logout($refreshToken) 
{
    // RefreshToken'ı veritabanında geçersiz kıl
    $result = $this->jwtService->invalidateRefreshToken($refreshToken);
    
    if ($result) {
        return json_encode(['success' => true, 'mesaj' => 'Başarıyla çıkış yapıldı']);
    } else {
        return json_encode(['success' => false, 'mesaj' => 'Çıkış yapılırken bir hata oluştu']);
    }
}
    public function refresh($request)
    {
        $refreshToken = $request['refreshToken'];

        $decoded = $this->jwtService->decodeToken($refreshToken);

        if ($decoded && $decoded->exp > time()) {
            $newAccessToken = $this->jwtService->createAccessToken($decoded->sub);

            return json_encode(['accessToken' => $newAccessToken]);
        }

        return json_encode(['error' => 'Geçersiz veya süresi dolmuş token'], JSON_PRETTY_PRINT);
    }

/*
    public function login($username, $password) {
        $user = $this->userRepo->getByUser($username);
        //$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id; // Kullanıcı ID'sini oturuma ekle
            $_SESSION['username'] = $user->username;
            return json_encode(['success' => true, 'message' => 'Giriş başarılı.','user'=>$user]);
        }
        return json_encode(['success' => false,'message' => 'Kullanıcı adı veya şifre hatalı.']);
    }
*/


    public function isAuthenticated() {
        if (isset($_SESSION['user_id'])) {
            return json_encode(['success' => true, 'user' => $_SESSION]);
        }

        return json_encode(['success' => false, 'message' => 'Kullanıcı oturum açmamış.']);
    }
}
