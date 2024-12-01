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
        $kullaniciadi = $request['kullaniciadi'] ?? null;
        $sifre = $request['sifre'] ?? null;

        if (!$kullaniciadi || !$sifre) {
            return json_encode(['success' => false,'error' => 'Kullanıcı adı veya şifre eksik'], JSON_PRETTY_PRINT);
        }

        $user = $this->userRepo->findUserByCredentials($kullaniciadi, $sifre);

        if ($user) {
            $accessToken = $this->jwtService->createAccessToken($user->id);
            $refreshToken = $this->jwtService->createRefreshToken($user->id);

            return json_encode([
                'accessToken' => $accessToken,
                'refreshToken' => $refreshToken,
            ]);
        }

        return json_encode(['success' => false,'error' => 'Geçersiz kimlik bilgileri'], JSON_PRETTY_PRINT);
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
    public function login($kullaniciadi, $sifre) {
        $user = $this->userRepo->getByUser($kullaniciadi);
        //$hashedPassword = password_hash($sifre, PASSWORD_BCRYPT);
        if ($user && password_verify($sifre, $user->sifre)) {
            $_SESSION['user_id'] = $user->id; // Kullanıcı ID'sini oturuma ekle
            $_SESSION['kullaniciadi'] = $user->kullaniciadi;
            return json_encode(['success' => true, 'message' => 'Giriş başarılı.','user'=>$user]);
        }
        return json_encode(['success' => false,'message' => 'Kullanıcı adı veya şifre hatalı.']);
    }
*/
    public function logout() {
        session_unset(); // Tüm oturum verilerini temizle
        session_destroy(); // Oturumu sonlandır
        return json_encode(['success' => true, 'message' => 'Çıkış başarılı.']);
    }

    public function isAuthenticated() {
        if (isset($_SESSION['user_id'])) {
            return json_encode(['success' => true, 'user' => $_SESSION]);
        }

        return json_encode(['success' => false, 'message' => 'Kullanıcı oturum açmamış.']);
    }
}
