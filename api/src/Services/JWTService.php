<?php

namespace Src\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    private $secretKey;
    private $accessTokenExpire;
    private $refreshTokenExpire;

    public function __construct()
    {
        $configPath = dirname(__DIR__, 2) . '/config/jwt.php';
        if (!file_exists($configPath)) {
            throw new Exception("JWT config file not found at $configPath");
        }
        
        $config = include($configPath);
        if (!is_array($config)) {
            throw new Exception("JWT config file must return an array.");
        }
        
        $this->secretKey = $config['secret_key'];
        $this->accessTokenExpire = $config['access_token_expire'];
        $this->refreshTokenExpire = $config['refresh_token_expire'];
    }

    public function createAccessToken($userId)
    {
        $payload = [
            'iss' => 'localhost:3000',  // Token sağlayıcı
            'aud' => 'localhost:3000',  // Token alıcı
            'iat' => time(),             // Oluşturulma zamanı
            'exp' => time() + $this->accessTokenExpire, // Bitiş zamanı
            'sub' => $userId             // Kullanıcı ID
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function createRefreshToken($userId)
    {
        $payload = [
            'iss' => 'localhost:3000',
            'aud' => 'localhost:3000',
            'iat' => time(),
            'exp' => time() + $this->refreshTokenExpire,
            'sub' => $userId
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function decodeToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            return null; // Geçersiz token
        }
    }
}
